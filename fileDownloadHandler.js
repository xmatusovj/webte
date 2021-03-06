lang = ''

function fileDownloadHandler() {
  var file = document.getElementById('fileToUpload').files[0]
  var delimiter = document.getElementById('delimiter').value
  //var body = document.getElementsByTagName('body')[0]

  var processedFileDownloadDiv = document.getElementById(
    'processedFileDownload'
  )
  if (delimiter == '') {
    const metas = document.getElementsByTagName('meta')
    for (let i = 0; i < metas.length; i++) {
      if (metas[i].getAttribute('name') === 'language') {
        if (metas[i].getAttribute('content') === 'sk') {
          lang = 'sk'
          processedFileDownloadDiv.innerHTML = 'Nezadali ste delimiter.'
        } else {
          lang = 'en'
          processedFileDownloadDiv.innerHTML = 'You havent set the delimiter.'
        }
        return
      } else {
        errorContainer.innerHTML = ''
      }
    }

    return
  }
  console.log(file)
  if (file == undefined) {
    if (lang === 'sk') {
      processedFileDownloadDiv.innerHTML = 'Nezadali ste CSV subor.'
    } else {
      processedFileDownloadDiv.innerHTML = 'You havent set the CSV file.'
    }
    return
  }

  var form = document.getElementById('formToSendFile')
  console.log(form)

  var formData = new FormData()
  formData.append('fileToUpload', file)
  formData.append('delimiter', delimiter)

  console.log(formData)

  fetch('./uploadBasicFile.php', {
    method: 'post',
    body: formData
  })
    .then(result => {
      return result.json()
    })
    .then(data => {
      console.log(data.result)

      console.log(data.result[0]['debug_POST'])
      var link = document.createElement('a')
      link.setAttribute('href', './downloadFileWithPasswords.php')
      link.innerText = data.result[0].name
      processedFileDownloadDiv.innerHTML = ''
      processedFileDownloadDiv.appendChild(link)
    })
}

function destroy_session() {
  var xmlhttp = new XMLHttpRequest()
  xmlhttp.open('GET', './fileSessionReset.php', false)
  xmlhttp.send(null)
}
