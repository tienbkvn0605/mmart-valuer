

function check_pattern_pass( str ) {
	// return str.match(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,15}$/)
	const regex = new RegExp('^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[-_])(?=.{8,20})');
	console.log(regex.test(str));
	return regex.test(str)
}

//
function check_katakana (str) {
	const regex = /^[�@-���[�@]+$/ ;
	if(regex.test(str) == false){
		alert("�U�����`�̓J�^�J�i�̂ݓ��͂��Ă��������B");
		return false;
	}
	return true;
}