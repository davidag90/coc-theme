const selectInscripcion = document.getElementById('tipo-estudiante');
const btnInscripcion = document.getElementById('btn-inscripcion');

selectInscripcion.addEventListener('change', (event) => {   
   let variationID = event.target.value;
   let btnInscripcionHREF = CHECKOUT_URL + variationID;

   btnInscripcion.setAttribute('href', btnInscripcionHREF);
   btnInscripcion.classList.remove('d-none');
   btnInscripcion.classList.add('d-block');
});