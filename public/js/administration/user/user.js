//const select2 = $('.select2'),
//selectPicker = $('.selectpicker');

var flatpickrDate = document.querySelector('#dateBirth');
select2 = $('.select2');

flatpickrDate.flatpickr({
  monthSelectorType: 'static'
});

const wizardValidation = document.querySelector('#wizard-validation');

if (typeof wizardValidation !== undefined && wizardValidation !== null) {
  // Wizard form
  const wizardValidationForm = wizardValidation.querySelector('#wizard-validation-form');
  // Wizard steps
  const wizardValidationFormStep1 = wizardValidationForm.querySelector('#account-details-validation');
  const wizardValidationFormStep2 = wizardValidationForm.querySelector('#personal-info-validation');
  const wizardValidationFormStep3 = wizardValidationForm.querySelector('#social-links-validation');
  // Wizard next prev button
  const wizardValidationNext = [].slice.call(wizardValidationForm.querySelectorAll('.btn-next'));
  const wizardValidationPrev = [].slice.call(wizardValidationForm.querySelectorAll('.btn-prev'));

  let validationStepper = new Stepper(wizardValidation, {
    linear: true
  });

  // Account details
  const FormValidation1 = FormValidation.formValidation(wizardValidationFormStep1, {
    fields: {
      email: {
        validators: {
          notEmpty: {
            message: oLang.emailRequired
          },
          emailAddress: {
            message: oLang.emailNotValid
          }
        }
      },
      confirmEmail: {
        validators: {
          notEmpty: {
            message: oLang.confirmEmailRequired
          },
          identical: {
            compare: function () {
              return wizardValidationFormStep1.querySelector('[name="email"]').value;
            },
            message: oLang.emailConfirmNotSame
          }
        }
      }
    },
    plugins: {
      trigger: new FormValidation.plugins.Trigger(),
      bootstrap5: new FormValidation.plugins.Bootstrap5({
        // Use this for enabling/changing valid/invalid class
        // eleInvalidClass: '',
        eleValidClass: ''
      }),
      autoFocus: new FormValidation.plugins.AutoFocus(),
      submitButton: new FormValidation.plugins.SubmitButton()
    },
    init: instance => {
      instance.on('plugins.message.placed', function (e) {
        //* Move the error message out of the `input-group` element
        if (e.element.parentElement.classList.contains('input-group')) {
          e.element.parentElement.insertAdjacentElement('afterend', e.messageElement);
        }
      });
    }
  }).on('core.form.valid', function () {
    // Jump to the next step when all fields in the current step are valid
    validationStepper.next();
  });

  if (UserId != '') {
    var togglePasswordCheckbox = $('#togglePasswordCheckbox');
    var passwordInput = $('#password');
    var confirmPasswordInput = $('#confirmPassword');

    togglePasswordCheckbox.change(function () {
      if ($('#togglePasswordCheckbox').prop('checked')) {
        passwordInput.prop('disabled', false);
        confirmPasswordInput.prop('disabled', false);
        FormValidation1.addField('password', {
          validators: {
            notEmpty: {
              message: oLang.passwordRequired
            }
          }
        });

        FormValidation1.addField('confirmPassword', {
          validators: {
            notEmpty: {
              message: oLang.confirmPaswordRequired
            },
            identical: {
              compare: function () {
                return wizardValidationFormStep1.querySelector('[name="password"]').value;
              },
              message: oLang.passwordConfirmNotSame
            }
          }
        });
      } else {
        FormValidation1.removeField('password');
        FormValidation1.removeField('confirmPassword');
        passwordInput.val('');
        confirmPasswordInput.val('');
        confirmPasswordInput.removeClass('is-invalid');
        passwordInput.prop('disabled', true);
        confirmPasswordInput.prop('disabled', true);
      }
    });
  } else {
    FormValidation1.addField('password', {
      validators: {
        notEmpty: {
          message: oLang.passwordRequired
        }
      }
    });

    FormValidation1.addField('confirmPassword', {
      validators: {
        notEmpty: {
          message: oLang.confirmPaswordRequired
        },
        identical: {
          compare: function () {
            return wizardValidationFormStep1.querySelector('[name="password"]').value;
          },
          message: oLang.passwordConfirmNotSame
        }
      }
    });
  }

  // Personal info
  const FormValidation2 = FormValidation.formValidation(wizardValidationFormStep2, {
    fields: {
      firstName: {
        validators: {
          notEmpty: {
            message: oLang.firstNameRequired
          }
        }
      },
      lastName: {
        validators: {
          notEmpty: {
            message: oLang.lastNameRequired
          }
        }
      }
    },
    plugins: {
      trigger: new FormValidation.plugins.Trigger(),
      bootstrap5: new FormValidation.plugins.Bootstrap5({
        // Use this for enabling/changing valid/invalid class
        // eleInvalidClass: '',
        eleValidClass: ''
      }),
      autoFocus: new FormValidation.plugins.AutoFocus(),
      submitButton: new FormValidation.plugins.SubmitButton()
    }
  }).on('core.form.valid', function () {
    // Jump to the next step when all fields in the current step are valid
    validationStepper.next();
    if (select2.length) {
      select2.each(function () {
        var $this = $(this);
        select2Focus($this);
        $this.wrap('<div class="position-relative"></div>').select2({
          placeholder: oLang.selectRol,
          dropdownParent: $this.parent()
        });
      });
    }
  });

  // Permissions
  const FormValidation3 = FormValidation.formValidation(wizardValidationFormStep3, {
    fields: {
      roles: {
        validators: {
          notEmpty: {
            message: oLang.youMustSelectRole
          }
        }
      }
    },
    plugins: {
      trigger: new FormValidation.plugins.Trigger(),
      bootstrap5: new FormValidation.plugins.Bootstrap5({
        // Use this for enabling/changing valid/invalid class
        // eleInvalidClass: '',
        eleValidClass: ''
      }),
      autoFocus: new FormValidation.plugins.AutoFocus(),
      submitButton: new FormValidation.plugins.SubmitButton()
    }
  }).on('core.form.valid', function () {
    if (UserId == '') {
      url = `${baseUrl}user`;
      type = 'POST';
    } else {
      url = `${baseUrl}user/` + UserId;
      type = 'PUT';
    }

    $.ajax({
      data: {
        //  id: UserId,
        email: $('#email').val(),
        password: $('#password').val(),
        first_name: $('#firstName').val(),
        last_name: $('#lastName').val(),
        contact: $('#contact').val(),
        date_birth: $('#dateBirth').val(),
        roles: $('#roles').val()
      },
      url: url,
      type: type,
      success: function (reponse) {
        Swal.fire({
          icon: 'success',
          title: oLang.successfully,
          text: reponse.message,
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });

        location.href = `${baseUrl}administration/users`;
      },
      error: function (err) {}
    });
  });

  wizardValidationNext.forEach(item => {
    item.addEventListener('click', event => {
      // When click the Next button, we will validate the current step
      switch (validationStepper._currentIndex) {
        case 0:
          FormValidation1.validate();
          break;

        case 1:
          FormValidation2.validate();
          break;

        case 2:
          FormValidation3.validate();
          break;

        default:
          break;
      }
    });
  });

  wizardValidationPrev.forEach(item => {
    item.addEventListener('click', event => {
      switch (validationStepper._currentIndex) {
        case 2:
          validationStepper.previous();
          break;

        case 1:
          validationStepper.previous();
          break;

        case 0:

        default:
          break;
      }
    });
  });
}
