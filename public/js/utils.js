function redirectToPage(pageToRedirect) {
  window.location.replace(pageToRedirect)
}

function getFormVars(form) {
  var formData = {}

  for (var i = 0; i < form.length; i++) {
    var input = form[i]
    if (input.name) {
      formData[input.name] = input.value
    }
  }

  return formData;
}

function showMessageTo(target, message) {
  $(target)
    .show('fast')
    .find('span')
    .html(message)
}

function showModalError(modal, message) {
  $(modal).find('.modal-body p').text(message)
  $('.modal:visible').modal('hide');
  $(modal).modal('show')
}