function fileDownloadHandler() {
  var file = document.getElementById('fileToUpload').files[0]
  var delimiter = document.getElementById('delimiter').value
  //var body = document.getElementsByTagName('body')[0]

  var processedFileDownloadDiv = document.getElementById(
    'processedFileDownload'
  )
  if (delimiter == '') {
    processedFileDownloadDiv.innerHTML = 'where is delimiter?'
    return
  }
  console.log(file)
  if (file == undefined) {
    processedFileDownloadDiv.innerHTML = 'where is file?'
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
