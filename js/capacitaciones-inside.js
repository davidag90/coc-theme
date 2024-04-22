import * as ENV from "./env.js";

async function fetchData(url) {
   const response = await fetch(url);
   
   return await response.json();
}

async function retrieveFeatImg(mediaId) {
   const endpoint = ENV.API_MEDIA_BASE + mediaId;
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
         post.thumbnail = ENV.THEME_URL + 'img/capacitaciones/placeholder.jpg';
      }

      return post;
   });
  
  return Promise.all(posts);
}

const fillCapacitaciones = (jsonCapacitaciones, especialidad = 'todos') => {
   jsonCapacitaciones.forEach((element) => {
      if(especialidad === 'todos') {
         let card = document.createElement('div');
         card.classList.add('card', 'capacitacion', `border-${element.especialidadSlug}`);
         card.setAttribute('coc-especialidad', element.especialidadSlug);
         
         let row = document.createElement('div');
         row.classList.add('row', 'g-0');

         let colImg = document.createElement('div');
         colImg.classList.add('col-sm-4');

         let cardImg = document.createElement('img');
         cardImg.setAttribute('src', element.thumbnail);
         cardImg.classList.add('img-fluid', 'rounded-start', 'h-100');

         colImg.append(cardImg);

         let colContent = document.createElement('div');
         colContent.classList.add('col-sm-8');
         
         let cardBody = document.createElement('div');
         cardBody.classList.add('card-body');
         
         let cardTitle = document.createElement('h3');
         cardTitle.classList.add('card-title', 'h5');
         cardTitle.innerHTML = element.titulo;
      
         let cardSubtitle = document.createElement('span');
         cardSubtitle.classList.add('d-block', 'text-secondary');
         
         let cardSubtitleInner = document.createElement('small');
         cardSubtitleInner.innerHTML = `${element.tipoCapacitacion} en ${element.especialidadNombre}`;
         
         cardSubtitle.append(cardSubtitleInner);
      
         let cardText = document.createElement('p');
         cardText.classList.add('card-text');
         cardText.innerHTML = element.fechaInicio;
      
         let callToAction = document.createElement('a');
         callToAction.setAttribute('href', element.link);
         callToAction.classList.add('btn', 'btn-sm', `btn-${element.especialidadSlug}`, 'ms-auto');
         callToAction.innerText = 'Más información';
      
         cardBody.append(cardSubtitle, cardTitle, cardText, callToAction);

         colContent.append(cardBody);
         
         row.append(colImg, colContent);

         card.append(row);
      
         appRoot.append(card);
      } else {
         if(especialidad === element.especialidadSlug) {
            let card = document.createElement('div');
            card.classList.add('card', 'capacitacion', `border-${element.especialidadSlug}`);
            card.setAttribute('coc-especialidad', element.especialidadSlug);
            
            let row = document.createElement('div');
            row.classList.add('row', 'g-0');
   
            let colImg = document.createElement('div');
            colImg.classList.add('col-sm-4');
   
            let cardImg = document.createElement('img');
            cardImg.setAttribute('src', element.thumbnail);
            cardImg.classList.add('img-fluid', 'rounded-start', 'h-100');
   
            colImg.append(cardImg);
   
            let colContent = document.createElement('div');
            colContent.classList.add('col-sm-8');
            
            let cardBody = document.createElement('div');
            cardBody.classList.add('card-body');
            
            let cardTitle = document.createElement('h3');
            cardTitle.classList.add('card-title', 'h5');
            cardTitle.innerHTML = element.titulo;
         
            let cardSubtitle = document.createElement('span');
            cardSubtitle.classList.add('d-block', 'text-secondary');
            
            let cardSubtitleInner = document.createElement('small');
            cardSubtitleInner.innerHTML = `${element.tipoCapacitacion} en ${element.especialidadNombre}`;
            
            cardSubtitle.append(cardSubtitleInner);
         
            let cardText = document.createElement('p');
            cardText.classList.add('card-text');
            cardText.innerHTML = element.fechaInicio;
         
            let callToAction = document.createElement('a');
            callToAction.setAttribute('href', element.link);
            callToAction.classList.add('btn', 'btn-sm', `btn-${element.especialidadSlug}`, 'ms-auto');
            callToAction.innerText = 'Más información';
         
            cardBody.append(cardSubtitle, cardTitle, cardText, callToAction);
   
            colContent.append(cardBody);
            
            row.append(colImg, colContent);
   
            card.append(row);
         
            appRoot.append(card);
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
const capacitaciones = await setData(ENV.API_CAPACITACIONES_URL);

document.addEventListener('DOMContentLoaded', fillCapacitaciones(capacitaciones));
document.addEventListener('DOMContentLoaded', setFiltros());