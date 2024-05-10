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

      post.slug = element.slug;
      post.title = element.title.rendered;
      post.integrantes = element.acf.integrantes;
      post.infoAdicional = element.acf.info_adicional;

      if(element.featured_media !== 0) {
         const featImgUrl = await retrieveFeatImg(element.featured_media);
         post.thumbnail = featImgUrl;
      } else {
         post.thumbnail = THEME_URL + 'img/sociedades/placeholder.jpg';
      }

      return post;
   });
  
  return Promise.all(posts);
}

function createItem(objSociedad) {
   let item = `
      <div class="card capacitacion border-secondary h-100">
         <img src="${objSociedad.thumbnail}" class="card-img-top border-secondary border-bottom" />
         <div class="card-body d-flex flex-column">
            <h3 class="card-title h5">${objSociedad.title}</h3>
            <div>${objSociedad.integrantes}</div>
            <div>${objSociedad.infoAdicional}</div>
            <button class="btn btn-sm btn-primary d-inline-block ms-auto mt-auto" data-bs-toggle="modal" data-bs-target="#modal-${objSociedad.slug}">Más información &rarr;</button>
         </div><!-- .card-body -->
      </div><!-- .card -->
   `;

   appRoot.innerHTML += item;
}

function createModals(objSociedad) {
   let modal = `
      <div class="modal fade" id="modal-${objSociedad.slug}" tabindex="-1" aria-labelledby="modal-${objSociedad.slug}-label" aria-hidden="true">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
                  <h1 class="modal-title fs-5" id="modal-${objSociedad.slug}-label">${objSociedad.title}</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               
               <div class="modal-body">
                  ${objSociedad.integrantes}
                  ${objSociedad.infoAdicional}
               </div>
            </div>
         </div>
      </div>
   `;

   modals.innerHTML += modal;
}

function fillSociedades(jsonSociedades) {
   jsonSociedades.forEach((element) => {
      createItem(element);
      createModals(element);
   });
}

const appRoot = document.getElementById('app-root');
const modals = document.getElementById('modals');
const sociedades = await setData(API_SOCIEDADES_URL);

document.addEventListener('DOMContentLoaded', fillSociedades(sociedades));
document.addEventListener('DOMContentLoaded', setFiltros());