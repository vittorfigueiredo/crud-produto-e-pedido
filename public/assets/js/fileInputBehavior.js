const fileInput = document.getElementById('inputFile');
const divInputFileBackground = document.getElementById('inputFileBackground');

fileInput.onchange = async function () {
  if(fileInput.files[0]) {
    const image = await toBase64(fileInput.files[0]);
    fileInput.style.backgroundColor = 'transparent';
    divInputFileBackground.style.background = `url(${image})`

    console.log('oi')
  }
};