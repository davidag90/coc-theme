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

      post.rubroSlug = element._embedded['wp:term'][0][0].slug;
      post.rubroNombre = element._embedded['wp:term'][0][0].name;
      post.prestador = element.title.rendered;
      post.slug = element.slug;
      post.resumen = element.excerpt.rendered;
      post.detalles = element.acf.detalles;
      post.fechaInicio = element.acf.fecha_inicio;
      post.link = element.link;

      if(element.featured_media !== 0) {
         const featImgUrl = await retrieveFeatImg(element.featured_media);
         post.thumbnail = featImgUrl;
      } else {
         post.thumbnail = THEME_URL + 'img/beneficios/placeholder.jpg';
      }

      return post;
   });
  
  return Promise.all(posts);
}

function createItem(objBeneficio) {
   let item = `
      <div class="card capacitacion border-secondary coc-rubro="${objBeneficio.rubroSlug}">
         <div class="row g-0">
            <div class="col-sm-4">
               <img src="${objBeneficio.thumbnail}" class="img-fluid rounded-start h-100" />
            </div><!-- .col-sm-4 -->
            <div class="col-sm-8">
               <div class="card-body d-flex flex-column h-100">
                  <h3 class="card-title h5">${objBeneficio.prestador}</h3>
                  <p class="card-text">${objBeneficio.resumen}</p>                  
                  <button class="btn btn-sm btn-primary d-inline-block ms-auto mt-auto" data-bs-toggle="modal" data-bs-target="#modal-${objBeneficio.slug}">Más información &rarr;</button>
               </div><!-- .card-body -->
            </div><!-- .col-sm-8 -->
         </div><!-- .row -->
      </div><!-- .card -->
   `;

   appRoot.innerHTML += item;
}

function createModals(objBeneficio) {
   let modal = `
      <div class="modal fade" id="modal-${objBeneficio.slug}" tabindex="-1" aria-labelledby="modal-${objBeneficio.slug}-label" aria-hidden="true">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
                  <h1 class="modal-title fs-5" id="modal-${objBeneficio.slug}-label">${objBeneficio.prestador}</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               
               <div class="modal-body">${objBeneficio.detalles}</div>
            </div>
         </div>
      </div>
   `;

   modals.innerHTML += modal;
}


function fillBeneficios(jsonBeneficios, rubro = 'todos') {
   jsonBeneficios.forEach((element) => {
      if(rubro === 'todos') {
         createItem(element);
         createModals(element);
      } else {
         if(rubro === element.rubroSlug) {
            createItem(element);
            createModals(element);
         }
      }
   });
}

function setFiltros() {
   const filtros = document.querySelectorAll('.filtro-rubro');
   
   filtros.forEach( (filtro) => {
      let rubro = filtro.getAttribute('coc-rubro');
      
      filtro.addEventListener('click', (event) => {
         appRoot.innerHTML = '';
         fillBeneficios(beneficios, rubro);
         
         filtros.forEach(elem => {
            elem.classList.remove('active');
         });
      
         event.target.classList.add('active');
      });
   });
   
   const filtrosMobile = document.querySelector('#filtros-rubro-mobile > select');
   
   filtrosMobile.addEventListener('change', (event) => {
      let rubro = event.target.value;
   
      appRoot.innerHTML = '';
      
      fillBeneficios(beneficios, rubro);
   });
}

const appRoot = document.getElementById('app-root');
const modals = document.getElementById('modals');
const beneficios = await setData(API_BENEFICIOS_URL);

document.addEventListener('DOMContentLoaded', fillBeneficios(beneficios));
document.addEventListener('DOMContentLoaded', setFiltros());