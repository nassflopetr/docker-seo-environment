<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Hall;
use App\Models\Order;
use App\Models\OrderHallSeat;
use App\Models\Show;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;

class ShowController extends Controller
{
    public function router(Request $request, ?string $showId = null): View|JsonResponse|RedirectResponse
    {
        if ($request->isMethod('post') && !\is_null($showId)) {
            return $this->buy($request, $showId);
        } else if ($request->isMethod('get') && !\is_null($showId)) {
            return $this->show($request, $showId);
        } else {
            return $this->shows($request);
        }
    }

    private function shows(Request $request): View
    {
        $shows = Show::whereBetween(
            'start_at',
            [(new \DateTime()), (new \DateTime())->add(new \DateInterval('P60D'))]
        )->orderBy('start_at')->get();

        return view('shows', [
            'metadata' => [
                'h1' => 'Вистави - Театральний Портал',
                'title' => 'Вистави - Театральний Портал',
                'description' => 'Дізнайтеся про найновіші вистави на Театральному Порталі та оберіть ту, яка зацікавить вас найбільше. Купуйте квитки та отримуйте неповторний театральний досвід.',
                'keywords' => 'вистави, театр, афіша, квитки, театральний портал',
                'og:title' => 'Вистави - Театральний Портал',
                'og:description' => 'Дізнайтеся про найновіші вистави на Театральному Порталі та оберіть ту, яка зацікавить вас найбільше. Купуйте квитки та отримуйте неповторний театральний досвід.',
            ],
            'shows' => $shows,
        ]);
    }

    private function show(Request $request, string $showId): View|RedirectResponse
    {
        $show = Show::where('id', '=', $showId)->first();

        if (\is_null($show)) {
            return redirect()->route('shows');
        }

        $metadata = $show->metadata;
        $hall = Hall::where('id', '=', $show->hall_id)->first();
        $occupiedSeats = OrderHallSeat::select('seat')->where('show_id', '=', $show->id)->get()->pluck('seat')->toArray();
        $gallery = Gallery::where('show_id', '=', $show->id)->get();

        return view('show', [
            'show' => $show,
            'gallery' => $gallery,
            'metadata' => $metadata,
            'hall' => $hall,
            'occupied_seats' => $occupiedSeats
        ]);
    }

    private function buy(Request $request, string $showId): JsonResponse
    {
        $show = Show::select('hall_id')->where('id', '=', $showId)->first();

        if (\is_null($show)) {
            return response()->json(['message' => 'Щось пішло не так. Оновіть сторінку, щоб повторити спробу.'], 403);
        }

        $hall = Hall::select('seats')->where('id', '=', $show->hall_id)->first();

        $data = $request->validate(
            [
                'full_name' => [
                    'required',
                    'bail',
                    'string',
                    'max:255',
                    'regex:/^[АаБбВвГгҐґДдЕеЄєЖжЗзИиІіЇїЙйКкЛлМмНнОоПпРрСсТтУуФфХхЦцЧчШшЩщЬьЮюЯяA-Z\'\-ʼ.\s]+$/i',
                ],
                'phone' => [
                    'required',
                    'bail',
                    'string',
                    'max:13',
                    'regex:/^(\+380)[0-9]{9}$/i',
                ],
                'email' => [
                    'required',
                    'bail',
                    'string',
                    'max:255',
                    'email',
                ],
                'comment' => [
                    'bail',
                    'string',
                    'nullable',
                    'max:500',
                    'regex:/^[АаБбВвГгҐґДдЕеЄєЖжЗзИиІіЇїЙйКкЛлМмНнОоПпРрСсТтУуФфХхЦцЧчШшЩщЬьЮюЯяA-Z\'\-ʼ.\s]+$/i',
                ],
                'seats' => [
                    'required',
                    'bail',
                    'array',
                    'min:1',
                ],
                'seats.*' => [
                    'required',
                    'bail',
                    'integer',
                    'min:1',
                    'max:' . $hall->seats,
                ],
            ],
            [
                'seats.required' => 'Щось пішло не так. Оновіть сторінку, щоб повторити спробу.',
                'seats.array' => 'Щось пішло не так. Оновіть сторінку, щоб повторити спробу.',
                'seats.min' => 'Щось пішло не так. Оновіть сторінку, щоб повторити спробу.',
                'seats.*.required' => 'Щось пішло не так. Оновіть сторінку, щоб повторити спробу.',
                'seats.*.integer' => 'Щось пішло не так. Оновіть сторінку, щоб повторити спробу.',
                'seats.*.min' => 'Щось пішло не так. Оновіть сторінку, щоб повторити спробу.',
                'seats.*.max' => 'Щось пішло не так. Оновіть сторінку, щоб повторити спробу.',
            ],
        );

        $seats = $data['seats'];

        if (OrderHallSeat::where('show_id', '=', $showId)->whereIn('seat', $seats)->count() > 0) {
            return response()->json([
                'message' => 'Одне із обраних вами місць уже зайняте. Оновіть сторінку, та оберіть місце із переліку вільних місць.'
            ], 403);
        }

        try {
            DB::beginTransaction();

            $order = new Order();

            $order->show_id = $showId;
            $order->full_name = $data['full_name'];
            $order->phone = $data['phone'];
            $order->email = $data['email'];
            $order->comment = $data['comment'];

            $order->save();

            $orderId = $order->id;

            DB::table((new OrderHallSeat())->getTable())->insert((function () use ($seats, $showId, $orderId) {
                $result = [];

                foreach ($seats as $seat) {
                    $result[] = ['order_id' => $orderId, 'show_id' => $showId, 'seat' => $seat];
                }

                return $result;
            })());

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::critical($exception->getMessage());

            return response()->json(['message' => 'Щось пішло не так. Оновіть сторінку, щоб повторити спробу.'], 403);
        }

        $request->session()->flash(
            'alerts',
            [['level' => 'success', 'message' => 'Замовлення успішно створено і оплачено. Квитки відправлені на вашу адресу електронної пошти.']]
        );

        return response()->json(['redirect' => URL::route('shows', ['id' => $showId])]);
    }
}
