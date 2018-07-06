require('../css/pronos.css');

$(document).ready(function(){
	$('#groupe-tab').on('click', function(){
		$('#groupes').addClass('active');
		deactivateTab('groupes');
	});
	if (!$('#huitieme-tab').hasClass('disabled')) {
		$('#huitieme-tab').on('click', function() {
			if ($('#huitiemes').find('p').length == 0) {
				showHuitiemesTab();
			} else {
				$('#huitiemes').addClass('active');
				deactivateTab('huitiemes');
			}		
		});
	}
	if (!$('#quart-tab').hasClass('disabled')) {
		$('#quart-tab').on('click', function() {
			if ($('#quarts').find('p').length == 0) {
				showQuartsTab();
			} else {
				$('#quarts').addClass('active');
				deactivateTab('quarts');
			}
		});
	}
	if (!$('#demi-tab').hasClass('disabled')) {
		$('#demi-tab').on('click', function() {
			if ($('#demis').find('p').length == 0) {
				showDemisTab();
			} else {
				$('#demis').addClass('active');
				deactivateTab('demis');
			}		
		});
	}
	if (!$('#finale-tab').hasClass('disabled')) {
		$('#finale-tab').on('click', function() {
			if ($('#finale').find('p').length == 0) {
				showFinaleTab();
			} else {
				$('#finale').addClass('active');
				deactivateTab('finale');
			}
		});
	}
});

function deactivateTab(step) {
	switch(step) {
		case 'groupes':
			if ($('#huitiemes').hasClass('active')) {
				$('#huitiemes').removeClass('active');
			} else if ($('#quarts').hasClass('active')) {
				$('#quarts').removeClass('active');
			} else if ($('#demis').hasClass('active')) {
				$('#demis').removeClass('active');
			} else if ($('#finale').hasClass('active')) {
				$('#finale').removeClass('active');
			}
		break;
		case 'huitiemes':
			if ($('#groupes').hasClass('active')) {
				$('#groupes').removeClass('active');
			} else if ($('#quarts').hasClass('active')) {
				$('#quarts').removeClass('active');
			} else if ($('#demis').hasClass('active')) {
				$('#demis').removeClass('active');
			} else if ($('#finale').hasClass('active')) {
				$('#finale').removeClass('active');
			}
		break;
		case 'quarts':
			if ($('#groupes').hasClass('active')) {
				$('#groupes').removeClass('active');
			} else if ($('#huitiemes').hasClass('active')) {
				$('#huitiemes').removeClass('active');
			} else if ($('#demis').hasClass('active')) {
				$('#demis').removeClass('active');
			} else if ($('#finale').hasClass('active')) {
				$('#finale').removeClass('active');
			}
		break;
		case 'demis':
			if ($('#groupes').hasClass('active')) {
				$('#groupes').removeClass('active');
			} else if ($('#huitiemes').hasClass('active')) {
				$('#huitiemes').removeClass('active');
			} else if ($('#quarts').hasClass('active')) {
				$('#quarts').removeClass('active');
			} else if ($('#finale').hasClass('active')) {
				$('#finale').removeClass('active');
			}
		break;
		case 'finale':
			if ($('#groupes').hasClass('active')) {
				$('#groupes').removeClass('active');
			} else if ($('#huitiemes').hasClass('active')) {
				$('#huitiemes').removeClass('active');
			} else if ($('#quarts').hasClass('active')) {
				$('#quarts').removeClass('active');
			} else if ($('#demis').hasClass('active')) {
				$('#demis').removeClass('active');
			}
		break;
	}
}

function showHuitiemesTab() {
	$.ajax({
		url: Routing.generate('home', {step: 'huitieme'}),
		success: function(data) {
			$('#huitiemes').addClass('active');
			deactivateTab('huitiemes');
			$.each(data['matches'], function(key, value) {
				$('#huitiemes').find('.row').append('<div class="col-3"><p class="text-center">'+value[0]+'<br>'+value[1]+'<br></p></div>');
			});
		}
	});
}

function showQuartsTab() {
	$.ajax({
		url: Routing.generate('home', {step: 'quart'}),
		success: function(data) {
			$('#quarts').addClass('active');
			deactivateTab('quarts');
			$.each(data['matches'], function(key, value) {
				$('#quarts').find('.row').append('<div class="col-3"><p class="text-center">'+value[0]+'<br>'+value[1]+'<br></p></div>');
			});
		}
	});
}

function showDemisTab() {
	$.ajax({
		url: Routing.generate('home', {step: 'demi'}),
		success: function(data) {
			alert(data);
		}
	});
}

function showFinaleTab() {
	$.ajax({
		url: Routing.generate('home', {step: 'finale'}),
		success: function(data) {
			alert(data);
		}
	});
}