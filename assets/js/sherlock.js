$(document).ready(function(){
	$('.carousel').carousel({
		interval:100*100*100
	});
	var count=1;
	$('.specialAnswerSubmitButton').on('click',function(){
		
		console.log('click');
		var level=$(this).data('level');
		var splQsNo=$(this).data('specialqsno');
		var answer=$('#answer'+splQsNo).val();
		if(answer.length>0){
			var answerObj={
				'splQsNo' : splQsNo,
				'splAnswer' : answer,
				'count' : count

			};
			$.post(CI.base_url+'ajaxController/validateSpecialAnswer',
				answerObj,
				function(data){
					if(data.result!='wrong'){
						//correct answer
						count++;
						//show image clue in a modal
						var modalMarkup=''
						+'<div id="clueModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">'
						 + '<div class="modal-body">'
						  +  '<p>'+data.result+'</p>'
						  +'</div>'
						+'</div>';
						//remove cluemodal if any
						$('#clueModal').remove();
						//append new cluemodal and show
						$('#Home').append(modalMarkup);
						$('#clueModal').modal({
							show:true
						});
						
						//remove the markup of the splDiv
						$('div#splDiv'+splQsNo).remove();
						if(data.finalClue){
							
							//finalclue shud be displayed in the wrapperdiv of the 4 spl qs
							$('div#splQsAnsDiv').html(data.finalClue);
						}

					}
					else{
						alert('Wrong answer!! Try again!');
					}

				},
				'json'
			);

		}
		else{
			alert('Answer a valid answer!');
		}

	});


	$('.showModalLink').on('click',function(){

		var img=$(this).data('imgLink');
		var modalMarkup=''
		+'<div id="simpleModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">'
		 +' <div class="modal-body">'
		  +'  <p>'+data.result+'</p>'
		  +'</div>'
		+'</div>';
		//remove simpleModal if any
		$('#simpleModal').remove();

		//show new simpleModal
		$('#Home').append(modalMarkup);
		$('#simpleModal').modal({
			show : true
		});
	});






});