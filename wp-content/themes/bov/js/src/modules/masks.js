export default function () {
  //Phone mask
  const phoneMask = ['+', /[1-9]/, /\d/, /\d/, /\d/, /\d/, /\d/, /\d/, /\d/, /\d/, /\d/, /\d/, /\d/];
  const myInputs = document.querySelectorAll('input[type="tel"]');

  for (let i = 0; i < myInputs.length; i++) {
    const maskedInputController = vanillaTextMask.maskInput({
      inputElement: myInputs[i],
      mask: phoneMask,
    });
  }

  d.on('blur', myInputs, function (e) {
    if (e.target.value.indexOf('_') !== -1) {
      e.target.value = ''
    }
  });
}