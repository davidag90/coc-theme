const appRoot = document.querySelector('.splide > .splide__track > .splide__list');
const APIURL = 'http://coc-dev.local/wp-json/wp/v2/capacitacion?_embed';

async function fetchData(url) {
   const response = await fetch(url);
   
   return await response.json();
}

async function setData(url) {
   const data = await fetchData(url);
   const posts = data.map((element) => {
     return {
       tipoCapacitacion: element.acf.tipo_capacitacion,
       especialidadSlug: element._embedded['wp:term'][0][0].slug,
       especialidadNombre: element._embedded['wp:term'][0][0].name,
       titulo: element.title.rendered,
       fechaInicio: element.acf.fecha_inicio,
       thumbnail: element._embedded['wp:featuredmedia'][0].link,
       link: element.link
     }
   });
  
  return posts;
}

const capacitaciones = await setData(APIURL);

const fillCapacitaciones = (jsonCapacitaciones, especialidad = 'todos') => {
   jsonCapacitaciones.forEach((element) => {
      if(especialidad === 'todos') {
         let card = document.createElement('div');
         card.classList.add('card', 'capacitacion', `border-${element.especialidadSlug}`, 'h-100');
         card.setAttribute('coc-especialidad', element.especialidadSlug);
      
         let cardImgTop = document.createElement('img');
         cardImgTop.setAttribute('src', element.thumbnail);
         cardImgTop.classList.add('card-img-top');
         
         let cardBody = document.createElement('div');
         cardBody.classList.add('card-body', 'd-flex', 'flex-column');
         
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
         callToAction.classList.add('btn', 'btn-sm', `btn-${element.especialidadSlug}`, 'ms-auto', 'mt-auto');
         callToAction.innerText = 'Más información';
      
         cardBody.append(cardSubtitle, cardTitle, cardText, callToAction);
         
         card.append(cardImgTop, cardBody);
      
         let slide = document.createElement('li');
         slide.classList.add('splide__slide');
         slide.append(card);
         
         appRoot.append(slide);
      } else {
         if(especialidad === element.especialidadSlug) {
            let card = document.createElement('div');
            card.classList.add('card', 'capacitacion', `border-${element.especialidadSlug}`, 'h-100');
            card.setAttribute('coc-especialidad', element.especialidadSlug);
         
            let cardImgTop = document.createElement('img');
            cardImgTop.setAttribute('src', element.thumbnail);
            cardImgTop.classList.add('card-img-top');
            
            let cardBody = document.createElement('div');
            cardBody.classList.add('card-body', 'd-flex', 'flex-column');
            
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
            callToAction.classList.add('btn', 'btn-sm', `btn-${element.especialidadSlug}`, 'ms-auto', 'mt-auto');
            callToAction.innerText = 'Más información';
         
            cardBody.append(cardSubtitle, cardTitle, cardText, callToAction);
            
            card.append(cardImgTop, cardBody);
         
            let slide = document.createElement('li');
            slide.classList.add('splide__slide');
            slide.append(card);
            
            appRoot.append(slide);
         }
      }
   });

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

document.addEventListener('DOMContentLoaded', fillCapacitaciones(capacitaciones));

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