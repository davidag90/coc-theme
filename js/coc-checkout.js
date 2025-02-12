const fieldInstitucion = document.getElementById('billing_institucion_field');
const inputInstitucion = document.getElementById('billing_institucion');
const selectCategoria = document.getElementById('billing_categoria');

selectCategoria.addEventListener('change', (event) => {
  if (event.target.value === 'socio-convenio') {
    inputInstitucion.value = '';
    fieldInstitucion.classList.remove('d-none');
  } else {
    fieldInstitucion.classList.add('d-none');
    inputInstitucion.value = 'No procede';
  }
});