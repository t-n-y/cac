/*

$('.noteAmbiance').on('change', function(){
	console.log($(this).find('.note-checked p').text());
	var noteAmbiance = $(this).find('.note-checked p').text();
	changeNote(noteAmbiance);
});

$('.noteConso').on('change', function(){
	console.log($(this).find('.note-checked p').text());
	var noteConso = $(this).find('.note-checked p').text();
	changeNote(noteConso);
});

$('.noteDeco').on('change', function(){
	console.log($(this).find('.note-checked p').text());
	var noteDeco = $(this).find('.note-checked p').text();
	changeNote(noteDeco);
});

$('.noteService').on('change', function(){
	console.log($(this).find('.note-checked p').text());
	var noteService = $(this).find('.note-checked p').text();
	changeNote(noteService);
});
*/
var noteAmbiance = 0;
var noteConso = 0;
var noteDeco = 0;
var noteService = 0;

$('.notes-echelle').on('change', function(){
	if($(this).hasClass('noteAmbiance')){
		console.log($(this).find('.note-checked p').text());
		noteAmbiance = $(this).find('.note-checked p').text();
	}

	if($(this).hasClass('noteConso')){
		console.log($(this).find('.note-checked p').text());
		noteConso = $(this).find('.note-checked p').text();
	}

	if($(this).hasClass('noteDeco')){
		console.log($(this).find('.note-checked p').text());
		noteDeco = $(this).find('.note-checked p').text();
	}

	if($(this).hasClass('noteService')){
		console.log($(this).find('.note-checked p').text());
		noteService = $(this).find('.note-checked p').text();
	}

	changeNote(noteAmbiance, noteConso, noteDeco, noteService);

});


function changeNote(noteAmbiance, noteConso, noteDeco, noteService){

	var note = 0;
	Number(noteAmbiance)
	note = ((Number(noteAmbiance) + Number(noteConso) + Number(noteDeco) + Number(noteService) ) / 4) * 2;

	$('.noteBar span').html();
	$('.noteBar span').html(note);
}