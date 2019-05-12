var quill
quill = new Quill('#editor', {
  theme: 'snow'
})
function sendEmail() {
  let selectedSchema = document.getElementById('schemaSelect').value
  let typeSchema = document.getElementById('schemaType').value
  let name = document.getElementById('name').value
  let email = document.getElementById('email').value
  let password = document.getElementById('password').value
  let emailTitle = document.getElementById('emailTitle').value
  let file = document.getElementById('file').files[0]
  let optionalFileToSend = document.getElementById('optionalFileToSend')
    .files[0]
  if (typeSchema === 'plain') {
    text = document.getElementById('plain').innerHTML

    // window.location.href = "/last/index.php?send=1&selectedSchema=" + selectedSchema + "&type=" + typeSchema +
    //     "&name=" + name + "&email=" + email + "&login=" + login + "&password=" + password + "&emailTitle=" +
    //     emailTitle +
    //     "&text=" + text;
  } else {
    text = quill.container.firstChild.innerHTML
    // window.location.href = encodeURI("/last/index.php?send=1&selectedSchema=" + selectedSchema + "&type=" +
    //     typeSchema +
    //     "&name=" + name + "&email=" + email + "&login=" + login + "&password=" + password + "&emailTitle=" +
    //     emailTitle +
    //     "&text=" + text + "&csv=email;name;\nxmaloch@is.stuba.sk;jozef maloch\n");
  }

  var formData = new FormData()
  if (name === '' || email === '' || password === '' || file === undefined) {
    let errorContainer = document.getElementById('errorContainer')
    const metas = document.getElementsByTagName('meta')

    for (let i = 0; i < metas.length; i++) {
      if (metas[i].getAttribute('name') == 'language') {
        if (metas[i].getAttribute('content') === 'sk')
          errorContainer.innerHTML =
            'Nezadali see meno odosielatela, email odosielatela, heslo odosielatela, subjekt emailu, alebo subor s datami.'
        else {
          errorContainer.innerHTML =
            'You havent set senders name, senders email, senders password, email subject or file with data.'
        }
        return
      }
    }
  }
  formData.append('selectedSchema', selectedSchema)
  formData.append('typeSchema', typeSchema)
  formData.append('name', name)
  formData.append('email', email)
  formData.append('password', password)
  formData.append('emailTitle', emailTitle)
  formData.append('text', text)
  formData.append('file', file)
  formData.append('optionalFileToSend', optionalFileToSend)

  fetch('./sender.php', {
    method: 'post',
    //enctype: 'multipart/form-data',
    body: formData
  })
    .then(result => {
      return result.json()
    })
    .then(data => {})
}

function saveSchema() {
  let text = quill.container.firstChild.innerHTML
  let plain = quill.getText()
  plain = plain.replace('\n', '%0A')
  //
  let name = document.getElementById('title').value
  window.location.href = encodeURI(
    '/webte_zadanie/uloha3.php?mail=' +
      text +
      '&name=' +
      name +
      '&plain=' +
      plain
  )
}
quill.on('text-change', function(delta, oldDelta, source) {
  let text = quill.container.firstChild.innerHTML
})

function selectSchema() {
  let selectedSchema = document.getElementById('schemaSelect').value

  let typeSchema = document.getElementById('schemaType').value
  window.location.href =
    '/webte_zadanie/uloha3.php?selectedSchema=' +
    selectedSchema +
    '&type=' +
    typeSchema
}
