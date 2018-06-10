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