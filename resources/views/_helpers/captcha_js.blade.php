const captchaData1 = Math.floor(Math.random() * 10) + 1;
const captchaData2 = Math.floor(Math.random() * 10) + 1;

$('#captchaData1').text(captchaData1);
$('#captchaData2').text(captchaData2);

const captchaResult = captchaData1 + captchaData2;

function captchaFunction() {
if (result_input.val() === captchaResult.toString()) {
btn_submit.show();
} else {
btn_submit.hide();
}
}

result_input.on('keyup', captchaFunction);
