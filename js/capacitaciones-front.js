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
      post.dictante = element.acf.dictante_principal_txt;
      post.titulo = element.title.rendered;
      post.fechaInicio = element.acf.fecha_inicio;
      post.fechaInicioDF = element.acf.fecha_inicio_dateformat;
      post.link = element.link;

      if(element.featured_media !== 0) {
         const featImgUrl = await retrieveFeatImg(element.featured_media);
         post.thumbnail = featImgUrl;
      } else {
         post.thumbnail = THEME_URL + 'img/capacitaciones/placeholder.jpg';
      }

      return post;
   });

   posts.sort((a,b) => {
      const keyA = new Date(a.fechaInicioDF);
      console.log(keyA);
      
      const keyB = new Date(b.fechaInicioDF);
      console.log(keyB);

      if (keyA < keyB) return -1;
      if (keyA < keyB) return 1;
      
      return 0;
   });
  
   return Promise.all(posts);
}

function startSplide() {
   const splideCapacitaciones = new Splide( '.splide', {
      type: 'slide',
      mediaQuery: 'min',
      gap: '1rem',
      padding: '1rem',
      pagination: false,
      breakpoints: {
         0: {
            perPage: 1,
            perMove: 1
         },
         576: {
            perPage: 2,
            perMove: 1
         },
         768: {
            perPage: 3,
            perMove: 1
         },
         1200: {
            perPage: 4,
            perMove: 1
         }
      }
   });
   
   splideCapacitaciones.mount();
}

function createSlide(objCapacitacion) {
   let slide = `
      <li class="splide__slide">
         <div class="card capacitacion border-${objCapacitacion.especialidadSlug} h-100 position-relative" coc-especialidad="${objCapacitacion.especialidadSlug}">
            <img src="${objCapacitacion.thumbnail}" class="card-img-top" />
            <div class="card-body d-flex flex-column">
               <h3 class="h5 card-title">${objCapacitacion.titulo}</h3>
               <span class="d-block text-secondary mb-3"><small>${objCapacitacion.tipoCapacitacion} en ${objCapacitacion.especialidadNombre}</small></span>
               <p class="card-text">${objCapacitacion.dictante}</p>
               <p class="card-text opacity-75">${objCapacitacion.fechaInicio}</p>
               <a href="${objCapacitacion.link}" class="btn btn-sm btn-${objCapacitacion.especialidadSlug} ms-auto mt-auto stretched-link">Más información &rarr;</a>
            </div><!-- .card-body -->
         </div><!-- .capacitacion -->
      </li><!-- .splide__slide -->
   `;

   appRoot.innerHTML += slide;
}

function fillCapacitaciones(jsonCapacitaciones, especialidad = 'todos') {
   jsonCapacitaciones.forEach((element) => {
      if(especialidad === 'todos') {
         createSlide(element);
      } else {
         if(especialidad === element.especialidadSlug) {
            createSlide(element);
         }
      }
   });

   startSplide();
}

function setFiltros() {
   const filtros = document.querySelectorAll('.filtro-espec');
   
   filtros.forEach( (filtro) => {
      let especialidad = filtro.getAttribute('coc-especialidad');
      
      filtro.addEventListener('click', (event) => {
         appRoot.innerHTML = '';
         fillCapacitaciones(capacitaciones, especialidad);
         
         filtros.forEach(elem => {
            let especialidadIn = elem.getAttribute('coc-especialidad');
            elem.classList.remove(`btn-${especialidadIn}`);
            elem.classList.add(`btn-outline-dark`);
         });
         
         event.target.classList.remove(`btn-outline-dark`);
         event.target.classList.add(`btn-${especialidad}`);
      });
   });
   
   const filtrosMobile = document.querySelector('#filtros-espec-mobile > select');
   
   filtrosMobile.addEventListener('change', (event) => {
      let especialidad = event.target.value;
   
      appRoot.innerHTML = '';
      
      fillCapacitaciones(capacitaciones, especialidad);
   });
}

const appRoot = document.querySelector('.splide > .splide__track > .splide__list');
const capacitaciones = await setData(API_CAPACITACIONES_URL);
console.log(capacitaciones);

document.addEventListener('DOMContentLoaded', fillCapacitaciones(capacitaciones));
document.addEventListener('DOMContentLoaded', setFiltros());