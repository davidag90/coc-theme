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
      post.beneficio = element.title.rendered;
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
                  <h3 class="card-title h5">${objBeneficio.beneficio}</h3>
                  <p class="card-text">${objBeneficio.resumen}</p>                  
                  <a href="${objBeneficio.link}" class="btn btn-sm btn-primary d-inline-block ms-auto mt-auto">Más información &rarr;</a>
               </div><!-- .card-body -->
            </div><!-- .col-sm-8 -->
         </div><!-- .row -->
      </div><!-- .card -->
   `;

   appRoot.innerHTML += item;
}

const fillBeneficios = (jsonBeneficios, rubro = 'todos') => {
   jsonBeneficios.forEach((element) => {
      if(rubro === 'todos') {
         createItem(element);
      } else {
         if(rubro === element.rubroSlug) {
            createItem(element);
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
const beneficios = await setData(API_BENEFICIOS_URL);

document.addEventListener('DOMContentLoaded', fillBeneficios(beneficios));
document.addEventListener('DOMContentLoaded', setFiltros());