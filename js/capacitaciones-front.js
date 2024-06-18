async function fetchData(url) {
   const response = await fetch(url);
   
   return await response.json();
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
         post.thumbnail = element._embedded['wp:featuredmedia'][0]['media_details']['sizes']['medium']['source_url']
      } else {
         post.thumbnail = THEME_URL + 'img/capacitaciones/placeholder.jpg';
      }

      return post;
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
   jsonCapacitaciones.sort((a, b) => {
      const dateA = new Date(
        a.fechaInicioDF.slice(0, 4),
        a.fechaInicioDF.slice(4, 6) - 1,
        a.fechaInicioDF.slice(6, 8)
      );
      const dateB = new Date(
        b.fechaInicioDF.slice(0, 4),
        b.fechaInicioDF.slice(4, 6) - 1,
        b.fechaInicioDF.slice(6, 8)
      );
      return dateA - dateB;
    });

   let preloader = document.getElementById('preloader');
   preloader.classList.add('d-none');
   
   jsonCapacitaciones.forEach((element) => {
      const hoy = new Date();
      const fechaCapacitacion = new Date(
         element.fechaInicioDF.slice(0, 4),
         element.fechaInicioDF.slice(4, 6) - 1,
         element.fechaInicioDF.slice(6, 8)
      );

      if(hoy < fechaCapacitacion) {
         if(especialidad === 'todos') {
            createSlide(element);
         } else {
            if(especialidad === element.especialidadSlug) {
               createSlide(element);
            }
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

document.addEventListener('DOMContentLoaded', fillCapacitaciones(capacitaciones));
document.addEventListener('DOMContentLoaded', setFiltros());