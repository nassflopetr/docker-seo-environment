'use strict';

/**
 * HTTP Response codes.
 *
 * @type {number}
 */
const HTTP_OK = 200,
    HTTP_BAD_REQUEST = 400,
    HTTP_UNAUTHORIZED = 401,
    HTTP_FORBIDDEN = 403,
    HTTP_TOKEN_MISMATCH = 419,
    HTTP_UNPROCESSABLE_ENTITY = 422,
    HTTP_TOO_MANY_REQUESTS = 429;

class Alert {
    /**
     * Initialize Alert object for given alert container element.
     *
     * @param element
     */
    constructor(element) {
        this._element = element;
    }

    /**
     * Show success alert with given message.
     *
     * @param message
     */
    success(message) {
        this._show('success', message);
    }

    /**
     * Show warning alert with given message.
     *
     * @param message
     */
    warning(message) {
        this._show('warning', message);
    }

    /**
     * Show danger alert with given message.
     *
     * @param message
     */
    danger(message) {
        this._show('danger', message);
    }

    /**
     * Show alert by level with given message.
     *
     * @param level
     * @param message
     * @private
     */
    _show(level, message) {
        const alertElement = (function (level, message) {
            const alertElement = this._getAlertElement(level);

            alertElement.append(this._getIconElement(level));
            alertElement.append(this._getMessageElement(message));
            alertElement.append(this._getCloseButtonElement());

            return alertElement;
        }.bind(this))(level, message);

        alertElement.addEventListener('close.bs.alert', function (event) {
            event.target.querySelector('button[data-bs-dismiss=\'alert\']').disabled = true;
        }, {once: true});

        setTimeout(function (alertElement) {
            alertElement.querySelector('button[data-bs-dismiss=\'alert\']').click();
        }, 15000, alertElement);

        this._element.append(alertElement);
    }

    /**
     * Get icon alert element for the given level.
     *
     * @param level
     * @returns {HTMLElement}
     * @private
     */
    _getIconElement(level) {
        const iconElement = document.createElement('i');

        let iconClassName = '';

        switch (level) {
            case 'success':
                iconClassName = 'bi-check-square';
                break;

            case 'warning':
                iconClassName = 'bi-info-square';
                break;

            case 'danger':
            default:
                iconClassName = 'bi-exclamation-square';
                break;
        }

        iconElement.classList.add('bi', iconClassName, 'me-2', 'align-middle', 'fs-3');

        return iconElement;
    }

    /**
     * Get message alert element for the given message.
     *
     * @param message
     * @returns {HTMLSpanElement}
     * @private
     */
    _getMessageElement(message) {
        const messageElement = document.createElement('span');

        messageElement.classList.add('align-middle');

        messageElement.append(document.createTextNode(message));

        return messageElement;
    }

    /**
     * Get close button alert element.
     *
     * @returns {HTMLButtonElement}
     * @private
     */
    _getCloseButtonElement() {
        const buttonElement = document.createElement('button');

        buttonElement.setAttribute('type', 'button');
        buttonElement.setAttribute('data-bs-dismiss', 'alert');
        buttonElement.setAttribute('aria-label', 'Close');

        buttonElement.classList.add('btn-close');

        return buttonElement;
    }

    /**
     * Get alert element with given level.
     *
     * @param level
     * @returns {HTMLDivElement}
     * @private
     */
    _getAlertElement(level) {
        const alertElement = document.createElement('div');

        alertElement.setAttribute('role', 'alert');

        alertElement.classList.add('alert', 'alert-' + level, 'alert-dismissible', 'fade', 'show');

        return alertElement;
    }
}

class Cookie {
    /**
     * Get value by the key from the cookies.
     *
     * @param key
     * @returns {string|string}
     */
    get(key) {
        const match = document.cookie.match(new RegExp('(^|;\\s*)(' + key + ')=([^;]*)'));

        return match ? decodeURIComponent(match[3]) : '';
    }
}

class Spinner {
    /**
     * Initialize Spinner object for given spinner element.
     *
     * @param element
     */
     constructor(element) {
         this._element = element;
     }

    /**
     * Show spinner.
     *
     * @param onShownEventHandler
     */
     show(onShownEventHandler) {
         if (typeof onShownEventHandler === 'function') {
             this._element.addEventListener('shown.bs.modal', onShownEventHandler, {once: true});
         }

         this._getInstance().show();
     }

    /**
     * Hide spinner.
     *
     * @param onHiddenEventHandler
     */
     hide(onHiddenEventHandler) {
         if (typeof onHiddenEventHandler === 'function') {
             this._element.addEventListener('hidden.bs.modal', onHiddenEventHandler, {once: true});
         }

         this._getInstance().hide();
     }

    /**
     * Get spinner object instance.
     *
     * @returns {*}
     * @private
     */
     _getInstance() {
         return bootstrap.Modal.getOrCreateInstance(this._element, {'backdrop': 'static', 'keyboard': false});
     }
}

class Validator {
    /**
     * Initialize Validator object for given form element.
     *
     * @param formElement
     * @param options
     */
    constructor(formElement, options) {
        if (typeof options === 'undefined') {
            // Default options.
            options = {};
        }

        this._formElement = formElement;

        // Validation rules.
        this._validators = typeof options.validators !== 'undefined' ? options.validators : {};

        // Form submission event handler.
        this._onSubmitEvent = typeof options.onSubmitEventHandler === 'function'
            ? options.onSubmitEventHandler.bind(this)
            : function (event) {
                if (!this.isValidForm()) {
                    event.preventDefault();

                    this.setFocusOnFirstInvalidField();
                }
            }.bind(this);

        // Form field input event handler.
        this._inputEvent = function (event) {
            this._validateElement(event.target);
        }.bind(this);

        const elements = this.getElements();

        // Add form field input event handler.
        for (let i = 0; i < elements.length; i++) {
            elements.item(i).addEventListener('input', this._inputEvent);
        }

        // Add form submission event handler.
        this.getFormSubmitButton().addEventListener('click', this._onSubmitEvent);
    }

    /**
     * Remove all validation event listeners, on form elements.
     */
    destroy() {
        const elements = this.getElements();

        // Remove form field input event handler.
        for (let i = 0; i < elements.length; i++) {
            elements.item(i).removeEventListener('input', this._inputEvent);
        }

        // Remove form submission event handler.
        this.getFormSubmitButton().removeEventListener('click', this._onSubmitEvent);
    }

    /**
     * Set focus on first form field.
     */
    setFocusOnFirstField() {
        const elements = this.getElements();

        if (elements.length > 0) {
            elements.item(0).focus();
        }
    }

    /**
     * Set focus on first invalid form field.
     */
    setFocusOnFirstInvalidField() {
        const elements = this.getElements();

        for (let i = 0; i < elements.length; i++) {
            let element = elements.item(i);

            if (this._isInvalid(element)) {
                element.focus();

                return;
            }
        }
    }

    /**
     * Set errors.
     *
     * @param errors
     */
    setErrors(errors) {
        const elements = this.getElements();

        for (let i = 0; i < elements.length; i++) {
            let element = elements.item(i),
                name = element.getAttribute('name');

            if (typeof errors[name] !== 'undefined') {
                for (let i = 0; i < errors[name].length; i++) {
                    this._setInvalid(element, errors[name][i]);
                }
            }
        }
    }

    /**
     * Validate form.
     *
     * @param except
     */
    validateForm(except) {
        if (typeof except === 'undefined') {
            except = [];
        }

        const elements = this.getElements();

        for (let i = 0; i < elements.length; i++) {
            let element = elements.item(i);

            if (except.length === 0 || except.indexOf(element.getAttribute('name')) === -1) {
                this._validateElement(element);
            }
        }
    }

    /**
     * Validate form field by field name.
     *
     * @param name
     */
    validateField(name) {
        const element = this.getElement(name);

        if (typeof element !== 'undefined') {
            this._validateElement(element);
        }
    }

    /**
     * Check if form is valid.
     *
     * @returns {boolean}
     */
    isValidForm() {
        if (!this.isValidatedForm()) {
            this.validateForm();
        }

        const elements = this.getElements();

        for (let i = 0; i < elements.length; i++) {
            if (this._isInvalid(elements.item(i))) {
                return false;
            }
        }

        return true;
    }

    /**
     * Check if field of form is valid.
     *
     * @param name
     * @returns {*}
     */
    isValidField(name) {
        const element = this.getElement(name);

        if (typeof element !== 'undefined') {
            if (!this._isValidated(element)) {
                this._validateElement(element);
            }

            return this._isValid(element);
        }
    }

    /**
     * Check if form was validated.
     *
     * @returns {boolean}
     */
    isValidatedForm() {
        const elements = this.getElements();

        for (let i = 0; i < elements.length; i++) {
            if (!this._isValidated(elements.item(i))) {
                return false;
            }
        }

        return true;
    }

    /**
     * Check if field of form was validated.
     *
     * @param name
     * @returns {boolean}
     */
    isValidatedField(name) {
        const element = this.getElement(name);

        if (typeof element === 'undefined') {
            return this._isValidated(element);
        }
    }

    /**
     * Set field of form as valid.
     *
     * @param name
     * @param message
     */
    setValidField(name, message) {
        const element = this.getElement(name);

        if (typeof element !== 'undefined') {
            this._setValid(element, message);
        }
    }

    /**
     * Set field of form as invalid.
     *
     * @param name
     * @param message
     */
    setInvalidField(name, message) {
        const element = this.getElement(name);

        if (typeof element !== 'undefined') {
            this._setInvalid(element, message);
        }
    }

    /**
     * Clear all validation on field of form.
     *
     * @param name
     */
    clearFieldValidation(name) {
        const element = this.getElement(name);

        if (typeof element !== 'undefined') {
            this._clearValidation(element);
        }
    }

    /**
     * Get validation form element.
     *
     * @returns {*}
     */
    getFormElement() {
        return this._formElement;
    }

    /**
     * Get form submit button.
     *
     * @returns {any}
     */
    getFormSubmitButton() {
        return this._formElement.querySelector('button[type=submit]');
    }

    /**
     * Get form elements for validation.
     *
     * @returns {NodeListOf<HTMLElementTagNameMap[string]> | NodeListOf<Element> | NodeListOf<SVGElementTagNameMap[string]>}
     */
    getElements() {
        const supportedElements = [
            'input.form-control',
            'textarea.form-control',
            'select.form-select',
            'input.form-check-input'
        ];

        return this._formElement.querySelectorAll(supportedElements.join(','));
    }

    /**
     * Clear validation on all elements of form.
     */
    clearFormValidation() {
        const elements = this.getElements();

        for (let i = 0; i < elements.length; i++) {
            this._clearValidation(elements.item(i));
        }
    }

    /**
     * Get element of form by name.
     *
     * @param name
     * @returns {Element}
     */
    getElement(name) {
        const elements = this.getElements();

        for (let i = 0; i < elements.length; i++) {
            let element = elements.item(i);

            if (element.getAttribute('name') === name) {
                return element;
            }
        }
    }

    /**
     * Check if field is validated.
     *
     * @param element
     * @returns {boolean}
     * @private
     */
    _isValidated(element) {
        if (!this._isValid(element) && !this._isInvalid(element)) {
            return false;
        }

        return true;
    }

    /**
     * Check if field is invalid.
     *
     * @param element
     * @returns {*}
     * @private
     */
    _isInvalid(element) {
        return element.classList.contains('is-invalid');
    }

    /**
     * Check if field is valid.
     *
     * @param element
     * @returns {*}
     * @private
     */
    _isValid(element) {
        return element.classList.contains('is-valid');
    }

    /**
     * Validate element of form.
     *
     * @param element
     * @private
     */
    _validateElement(element) {
        const validators = this._getElementValidators(element);

        let valid = true,
            message = '';

        for (let validator in validators) {
            if (!validators.hasOwnProperty(validator)) {
                continue;
            }

            if (typeof validators[validator] === 'function') {
                let result = (validators[validator].bind(this))(element);

                valid = typeof result.valid === 'boolean' ? result.valid : true;
                message = typeof result.message === 'string' ? result.message : '';

                if (!valid) {
                    // Exit after first validation error.
                    break;
                }
            }
        }

        valid ? this._setValid(element, message) : this._setInvalid(element, message);
    }

    /**
     * Get element of form validators.
     *
     * @param element
     * @returns {{callback: (function(*): {valid: boolean, message: string})}|*}
     * @private
     */
    _getElementValidators(element) {
        const name = element.getAttribute('name');

        if (typeof this._validators[name] !== 'undefined') {
            return this._validators[name];
        } else {
            // Default validator.
            return {
                'callback': function (element) {
                    return {'valid': true};
                }
            };
        }
    }

    /**
     * Set element of form as valid.
     *
     * @param element
     * @param message
     * @private
     */
    _setValid(element, message) {
        this._clearValidation(element);

        element.classList.add('is-valid');
        element.after(this._getValidFeedbackElement(message));
    }

    /**
     * Set element of form as invalid.
     *
     * @param element
     * @param message
     * @private
     */
    _setInvalid(element, message) {
        this._clearValidation(element);

        element.classList.add('is-invalid');
        element.after(this._getInvalidFeedbackElement(message));
    }

    /**
     * Clear all validation on element of form.
     *
     * @param element
     * @private
     */
    _clearValidation(element) {
        element.classList.remove('is-invalid', 'is-valid');

        const feedbacks = element.closest('div')
            .querySelectorAll('div.invalid-feedback, div.valid-feedback');

        for (let i = 0; i < feedbacks.length; i++) {
            feedbacks.item(i).remove();
        }
    }

    /**
     * Get validation valid feedback element.
     *
     * @param message
     * @returns {HTMLDivElement}
     * @private
     */
    _getValidFeedbackElement(message) {
        return this._getFeedbackElement(true, message);
    }

    /**
     * Get validation invalid feedback element.
     *
     * @param message
     * @returns {HTMLDivElement}
     * @private
     */
    _getInvalidFeedbackElement(message) {
        return this._getFeedbackElement(false, message);
    }

    /**
     * Get validation feedback element.
     *
     * @param isValid
     * @param message
     * @returns {HTMLDivElement}
     * @private
     */
    _getFeedbackElement(isValid, message) {
        if (typeof isValid !== 'boolean') {
            isValid = true;
        }

        const element = document.createElement('div');

        element.classList.add(isValid ? 'valid-feedback' : 'invalid-feedback');

        if (typeof message === 'string' && message !== '') {
            element.append(document.createTextNode(message));
        }

        return element;
    }
}

function show(parameters) {
    // Генерація місць у залі
    (function (seats, occupiedSeats) {
        const container = document.getElementById('map');

        for (let i = seats; i >= 1; i--) {
            const seat = document.createElement('div');

            seat.classList.add('border', 'border-1', 'rounded-1', 'm-1', 'text-center', 'd-inline-block', 'seat');
            seat.style.cursor = 'pointer';
            seat.setAttribute('seat-id', i);
            seat.textContent = i;

            if (occupiedSeats.indexOf(i) !== -1) {
                seat.classList.add('bg-secondary', 'text-white');
            }

            seat.addEventListener('click', function() {
                if(!this.classList.contains('bg-secondary')) {
                    this.classList.toggle('bg-success');
                    this.classList.toggle('text-white');
                }
            });

            container.appendChild(seat);
        }
    })(parameters.seats, parameters.occupied_seats);

    // Обробка замовлення.
    (function (price) {
        const alert = new Alert(document.getElementById('alerts')),
            spinner = new Spinner(document.getElementById('spinner')),
            modalElement = document.getElementById('modal'),
            modal = bootstrap.Modal.getOrCreateInstance(modalElement),
            validator = new Validator(modalElement.querySelector('form'), {
                'validators': {
                    'full_name': {
                        'callback': function (element) {
                            const value = element.value.trim();

                            if (value === '') {
                                return {
                                    'valid': false,
                                    'message': 'Поле обов\'язкове для заповнення.'
                                };
                            }

                            if (value.length > 255) {
                                return {
                                    'valid': false,
                                    'message': 'Поле не може бути більше ніж 255 символів.'
                                }
                            }

                            if (
                                (new RegExp(/^[АаБбВвГгҐґДдЕеЄєЖжЗзИиІіЇїЙйКкЛлМмНнОоПпРрСсТтУуФфХхЦцЧчШшЩщЬьЮюЯяA-Z'\-ʼ.\s]+$/, 'i').test(value))
                            ) {
                                return {'valid': true};
                            }

                            return {
                                'valid': false,
                                'message': 'Дозволені лише латинські та українські літери та символи \'-ʼ..'
                            };
                        }
                    },
                    'phone': {
                        'callback': function (element) {
                            const value = element.value.trim();

                            if (value === '') {
                                return {
                                    'valid': false,
                                    'message': 'Поле обов\'язкове для заповнення.'
                                };
                            }

                            if ((new RegExp(/^(\+380)[0-9]{9}$/).test(value))) {
                                return {'valid': true};
                            }

                            return {
                                'valid': false,
                                'message': 'Поле має місити коректний номер телефону.'
                            };
                        }
                    },
                    'email': {
                        'callback': function (element) {
                            const value = element.value.trim();

                            if (value === '') {
                                return {
                                    'valid': false,
                                    'message': 'Поле обов\'язкове для заповнення.'
                                };
                            }

                            if ((new RegExp(/^(.)+@(.)+\.(.){2,4}$/).test(value))) {
                                return {'valid': true};
                            }

                            return {
                                'valid': false,
                                'message': 'Поле має місити коректну адресу електронної пошти.'
                            };
                        }
                    },
                    'comment': {
                        'callback': function (element) {
                            const value = element.value.trim();

                            if (value === '') {
                                return {
                                    'valid': true
                                };
                            }

                            if (value.length > 500) {
                                return {
                                    'valid': false,
                                    'message': 'Поле не може бути більше ніж 500 символів.'
                                }
                            }

                            if (
                                (new RegExp(/^[АаБбВвГгҐґДдЕеЄєЖжЗзИиІіЇїЙйКкЛлМмНнОоПпРрСсТтУуФфХхЦцЧчШшЩщЬьЮюЯяA-Z'\-ʼ.\s]+$/, 'i').test(value))
                            ) {
                                return {'valid': true};
                            }

                            return {
                                'valid': false,
                                'message': 'Дозволені лише латинські та українські літери та символи \'-ʼ..'
                            };
                        }
                    },
                    'card_number': {
                        'callback': function (element) {
                            const value = element.value.trim();

                            if (value === '') {
                                return {
                                    'valid': false,
                                    'message': 'Поле обов\'язкове для заповнення.'
                                };
                            }

                            if (value.length > 16) {
                                return {
                                    'valid': false,
                                    'message': 'Поле не може бути більше ніж 16 символів.'
                                }
                            }

                            if (
                                (new RegExp(/^[0-9]{16}$/, 'i').test(value))
                            ) {
                                return {'valid': true};
                            }

                            return {
                                'valid': false,
                                'message': 'Поле має місити коректний номер банківської картки.'
                            };
                        }
                    },
                    'expiry_date': {
                        'callback': function (element) {
                            const value = element.value.trim();

                            if (value === '') {
                                return {
                                    'valid': false,
                                    'message': 'Поле обов\'язкове для заповнення.'
                                };
                            }

                            if (value.length > 16) {
                                return {
                                    'valid': false,
                                    'message': 'Поле не може бути більше ніж 5 символів.'
                                }
                            }

                            if (
                                (new RegExp(/^[0-9]{2}\/[0-9]{2}$/, 'i').test(value))
                            ) {
                                return {'valid': true};
                            }

                            return {
                                'valid': false,
                                'message': 'Поле має місити коректний термін дії банківської картки.'
                            };
                        }
                    },
                    'cvv': {
                        'callback': function (element) {
                            const value = element.value.trim();

                            if (value === '') {
                                return {
                                    'valid': false,
                                    'message': 'Поле обов\'язкове для заповнення.'
                                };
                            }

                            if (value.length > 3) {
                                return {
                                    'valid': false,
                                    'message': 'Поле не може бути більше ніж 3 символів.'
                                }
                            }

                            if (
                                (new RegExp(/^[0-9]{3}$/, 'i').test(value))
                            ) {
                                return {'valid': true};
                            }

                            return {
                                'valid': false,
                                'message': 'Поле має місити коректний CVV код банківської картки.'
                            };
                        }
                    }
                },
                'onSubmitEventHandler': function (event) {
                    event.preventDefault();

                    if (this.isValidForm()) {
                        const request = new XMLHttpRequest(),
                            headers = {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-XSRF-TOKEN': (new Cookie).get('XSRF-TOKEN')
                            };

                        request.responseType = 'json';
                        request.timeout = 30000;

                        request.open(
                            this.getFormElement().getAttribute('method'),
                            this.getFormElement().getAttribute('action')
                        );

                        for (let headerName in headers) {
                            if (headers.hasOwnProperty(headerName)) {
                                request.setRequestHeader(headerName, headers[headerName]);
                            }
                        }

                        request.addEventListener('loadstart', function (event) {
                            spinner.show();
                        });

                        request.addEventListener('error', function (event) {
                            alert.danger('Щось пішло не так. Оновіть сторінку, щоб повторити спробу.');
                        });

                        request.addEventListener('timeout', function (event) {
                            alert.warning('Час очікування вашого запиту минув. Оновіть сторінку, щоб повторити запит.');
                        });

                        request.addEventListener('loadend', function (event) {
                            if (request.readyState !== request.DONE) {
                                alert.danger('Щось пішло не так. Оновіть сторінку, щоб повторити спробу.');

                                spinner.hide(function (event) {
                                    this.setFocusOnFirstField();
                                }.bind(this));
                            } else {
                                switch (request.status) {
                                    case HTTP_OK:
                                        const link = document.createElement('a');

                                        link.setAttribute('href', request.response.redirect);

                                        link.click();

                                        break;

                                    case HTTP_UNPROCESSABLE_ENTITY:
                                        this.setErrors(request.response.errors);

                                        for (let key in request.response.errors) {
                                            if (['full_name', 'phone', 'email', 'comment'].indexOf(key) === -1) {
                                                for (let i = 0; i < request.response.errors[key].length; i++) {
                                                    alert.danger(request.response.errors[key][i]);
                                                }
                                            }
                                        }

                                        spinner.hide(function (event) {
                                            this.setFocusOnFirstInvalidField();
                                        }.bind(this));

                                        break;

                                    case HTTP_TOO_MANY_REQUESTS:
                                        alert.warning(request.response.message);

                                        spinner.hide(function (event) {
                                            this.getFormSubmitButton().focus();
                                        }.bind(this));

                                        break;

                                    case HTTP_BAD_REQUEST:
                                    case HTTP_FORBIDDEN:
                                    case HTTP_TOKEN_MISMATCH:
                                    default:
                                        if (
                                            typeof request.response === 'object'
                                            && request.response !== null
                                            && typeof request.response.message === 'string'
                                        ) {
                                            alert.danger(request.response.message);
                                        } else {
                                            alert.danger('Щось пішло не так. Оновіть сторінку, щоб повторити спробу.');
                                        }

                                        spinner.hide(function (event) {
                                            this.setFocusOnFirstField();
                                        }.bind(this));

                                        break;
                                }
                            }
                        }.bind(this));

                        request.send((function () {
                            const formData = new FormData();

                            document.querySelectorAll('#map > div.bg-success').forEach(function (element) {
                                formData.append('seats[]', element.getAttribute('seat-id'));
                            });

                            this.getElements().forEach(function (element) {
                                if (['amount', 'card_number', 'expiry_date', 'cvv'].indexOf(element.getAttribute('name')) === -1) {
                                    formData.append(element.getAttribute('name'), element.value.trim());
                                }
                            });

                            return formData;
                        }.bind(this))());
                    } else {
                        this.setFocusOnFirstInvalidField();
                    }
                }
            });

        // Встановлення суми замовлення.
        modalElement.addEventListener('show.bs.modal', function (event) {
            modalElement.querySelector('input[name=amount]').value =
                (price * document.querySelectorAll('#map > div.bg-success').length) + '₴';
        });

        // Фокус на першому полі форми.
        modalElement.addEventListener('shown.bs.modal', function (event) {
            validator.setFocusOnFirstField();
        });

        // Очищення полів форми.
        modalElement.addEventListener('hidden.bs.modal', function (event) {
            validator.getElements().forEach(function (element) {
                element.value = '';
            });

            validator.clearFormValidation();
        });

        document.getElementById('pay').addEventListener('click', function () {
            validator.getFormSubmitButton().click();
        });

        document.getElementById('make-order').addEventListener('click', function () {
            if (document.querySelectorAll('#map > div.bg-success').length > 0) {
                modal.toggle();
            } else {
                alert.warning('Не обрано жодного місця.');
            }
        });
    })(parameters.price);

    // Обробка нотифікацій.
    (function (alerts) {
        if (alerts.length > 0) {
            const alert = new Alert(document.getElementById('alerts'));

            for (let i = 0; i < alerts.length; i++) {
                switch (alerts[i]['level']) {
                    case 'success':
                        alert.success(alerts[i]['message']);
                        break;

                    case 'warning':
                        alert.warning(alerts[i]['message']);
                        break;

                    case 'danger':
                    default:
                        alert.danger(alerts[i]['message']);
                        break;
                }
            }
        }
    })(parameters.alerts);
}
