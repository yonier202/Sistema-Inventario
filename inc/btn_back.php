<p class="has-text-left pt-4 pb-4">
	<a href="#" class="button is-link is-rounded btn-back">
	<i class="fas fa-undo-alt mx-1"></i>	
	Regresar atrás</a>
</p>
<script type="text/javascript">
	let btn_back = document.querySelector(".btn-back");

	 btn_back.addEventListener('click', function(e){
	     e.preventDefault();
	    window.history.back();
	});
</script>