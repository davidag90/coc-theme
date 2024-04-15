const appRoot = document.getElementById('app-root');
const APIURL = 'https://dagdev.com.ar/coc-dev/wp-json/wp/v2/capacitaciones?_embed';

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

document.addEventListener('DOMContentLoaded', fillCapacitaciones(capacitaciones));

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