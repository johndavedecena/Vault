$( "#start-datepicker" ).datepicker({ 
	dateFormat: 'yy-mm-dd',
	changeMonth: true,
    changeYear: true });
$( "#end-datepicker" ).datepicker({ 
	dateFormat: 'yy-mm-dd',
	changeMonth: true,
	changeYear: true});
$( "#emp-datepicker" ).datepicker({ 
	dateFormat: 'yy-mm-dd',
	changeMonth: true,
	changeYear: true});
$( "#ituse-datepicker" ).datepicker({ dateFormat: 'yy-mm-dd'});
$( "#recruitment-datepicker" ).datepicker({ dateFormat: 'yy-mm-dd'});
$( "#returned-datepicker" ).datepicker({ dateFormat: 'yy-mm-dd'});
$( "#transferred-datepicker" ).datepicker({ dateFormat: 'yy-mm-dd'});
$( "#lost-datepicker" ).datepicker({ dateFormat: 'yy-mm-dd'});
$( "#retired-datepicker" ).datepicker({ dateFormat: 'yy-mm-dd'});
$('#laptopNull').show();
$('select[name=laptopStatus]').change(function(){
if( $('select[name=laptopStatus] option:selected').val() == '0' ) {
    $('.optionBox').hide();
    $('#laptopNull').show();
}else if ( $('select[name=laptopStatus] option:selected').val() == '1' ) {
    $('.optionBox').hide();
    $('#laptopReturned').show();
}else if ( $('select[name=laptopStatus] option:selected').val() == '2' ) {
    $('.optionBox').hide();
    $('#laptopRemarks').show();
}else if ( $('select[name=laptopStatus] option:selected').val() == '3' ) {
    $('.optionBox').hide();
    $('#laptopITIssued').show();
}else if ( $('select[name=laptopStatus] option:selected').val() == '4' ) {
    $('.optionBox').hide();
    $('#laptopLost').show();
}else if ( $('select[name=laptopStatus] option:selected').val() == '5' ) {
    $('.optionBox').hide();
    $('#laptopTransferred').show();
}else if ( $('select[name=laptopStatus] option:selected').val() == '6' ) {
    $('.optionBox').hide();
    $('#laptopRecruitment').show();
}else if ( $('select[name=laptopStatus] option:selected').val() == '7' ) {
    $('.optionBox').hide();
    $('#laptopRetired').show();
}else if ( $('select[name=laptopStatus] option:selected').val() == '8' ) {
    $('.optionBox').hide();
    $('#laptopTest').show();
}
});