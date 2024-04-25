async function fetchData(url) {
   const response = await fetch(url);
   
   return await response.json();
}

async function retrieveFeatImg(mediaId) {
   const endpoint = API_MEDIA_BASE + mediaId;
   const response = await fetch(endpoint);
   const mediaData = await response.json();
   
   return mediaData.source_url;
}

async function setData(url) {
   const data = await fetchData(url);

   const posts = data.map( async(element) => {
      let post = {};

      post.tipoCapacitacion = element.acf.tipo_capacitacion;
      post.especialidadSlug = element._embedded['wp:term'][0][0].slug;
      post.especialidadNombre = element._embedded['wp:term'][0][0].name;
      post.titulo = element.title.rendered;
      post.fechaInicio = element.acf.fecha_inicio;
      post.link = element.link;

      if(element.featured_media !== 0) {
         const featImgUrl = await retrieveFeatImg(element.featured_media);
         post.thumbnail = featImgUrl;
      } else {
         post.thumbnail = THEME_URL + 'img/capacitaciones/placeholder.jpg';
      }

      return post;
   });
  
  return Promise.all(posts);
}

function createItem(objCapacitacion) {
   let item = `
      <div class="card capacitacion border-${objCapacitacion.especialidadSlug}" coc-especialidad="${objCapacitacion.especialidadSlug}">
         <div class="row g-0">
            <div class="col-sm-4">
               <img src="${objCapacitacion.thumbnail}" class="img-fluid rounded-start" />
            </div><!-- .col-sm-4 -->
            <div class="col-sm-8">
               <div class="card-body d-flex flex-column h-100">
                  <h3 class="card-title h5">${objCapacitacion.titulo}</h3>
                  <span class="d-block text-secondary"><small>${objCapacitacion.tipoCapacitacion} en ${objCapacitacion.especialidadNombre}</small></span>
                  <p class="card-text">${objCapacitacion.fechaInicio}</p>
                  <a href="${objCapacitacion.link}" class="btn btn-sm btn-${objCapacitacion.especialidadSlug} d-inline-block ms-auto mt-auto">Más información &rarr;</a>
               </div><!-- .card-body -->
            </div><!-- .col-sm-8 -->
         </div><!-- .row -->
      </div><!-- .card -->
   `;

   appRoot.innerHTML += item;
}

const fillCapacitaciones = (jsonCapacitaciones, especialidad = 'todos') => {
   jsonCapacitaciones.forEach((element) => {
      if(especialidad === 'todos') {
         createItem(element);
      } else {
         if(especialidad === element.especialidadSlug) {
            createItem(element);
         }
      }
   });
}

function setFiltros() {
   const filtros = document.querySelectorAll('.filtro-espec');
   
   filtros.forEach( (filtro) => {
      let especialidad = filtro.getAttribute('coc-especialidad');
      
      filtro.addEventListener('click', (event) => {
         appRoot.innerHTML = '';
         fillCapacitaciones(capacitaciones, especialidad);
         
         filtros.forEach(elem => {
            elem.classList.remove('active');
         });
      
         event.target.classList.add('active');
      });
   });
   
   const filtrosMobile = document.querySelector('#filtros-espec-mobile > select');
   
   filtrosMobile.addEventListener('change', (event) => {
      let especialidad = event.target.value;
   
      appRoot.innerHTML = '';
      
      fillCapacitaciones(capacitaciones, especialidad);
   });
}

const appRoot = document.getElementById('app-root');
const capacitaciones = await setData(API_CAPACITACIONES_URL);

document.addEventListener('DOMContentLoaded', fillCapacitaciones(capacitaciones));
document.addEventListener('DOMContentLoaded', setFiltros());