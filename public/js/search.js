window.addEventListener("DOMContentLoaded", () => {

    //FOR SEARCH CONTAINER
  let btn = document.querySelector(".btn");
  let panel = document.querySelector(".container");
  let close = document.querySelector(".close");
  const inputSearch = document.querySelector('input[type=search]');
  let containeResultSearch = document.querySelector('#searchResult');
  const formSearch = document.querySelector('form[class=nav__search]')
  let indexSelect =  -1;
  let interuptSearch = false

      //FOR NAV HOME
    const NavBarre = document.querySelector('.nav')
    const linkLogo = document.querySelector('.nav__link')
    let posTarget = false
    const limitedStand = window.innerWidth*0.478


    if(window.location.pathname === '/kawa/')
    {
        const LogoWhite = document.createElement('img')
        LogoWhite.src= "/kawa/public/assets/pictures/kawa_logo_white.svg";
        LogoWhite.alt = "revenir à l'accuil principal";
        LogoWhite.classList.add('logoWhiteDesktop')


        linkLogo.append(LogoWhite)
        
        NavBarre.classList.add('homeStyleDesktop')
        window.addEventListener('scroll', (event) => {
            if(window.scrollY > limitedStand && posTarget !== true)
            {
                posTarget = true
                LogoWhite.classList.remove('animationLogoOut')
                NavBarre.classList.remove('animateNavDesktopOut')
                NavBarre.classList.remove('homeStyleDesktop')
                NavBarre.classList.add('animateNavDesktop')
                LogoWhite.classList.add('animationLogo')
            }
            else if(window.scrollY < limitedStand && posTarget !== false) {
                posTarget = false
                LogoWhite.classList.remove('animationLogo')
                LogoWhite.classList.add('animationLogoOut')
                NavBarre.classList.remove('animateNavDesktop')
                NavBarre.classList.add('animateNavDesktopOut')
                //
            }
        })
        
    }
 
  btn.addEventListener("click", () => {
    panel.classList.add("active");
  });

  close.addEventListener("click", () => {
    panel.classList.remove("active");
  });


   //formSearch.addEventListener('submit', (event) => event.preventDefault)
   
      /**
     * Change la casse en capitale du premier caractère sur une chène donnée
     * @param {*} a chaine de caractère
     * @returns la chaine de cractère donnée avec un capitale
     */
       function strUcFirst(a)
       {
           return (a+'').charAt(0).toUpperCase()+a.substr(1);
       }

   /**
     * Fonction spécifique
     * Créer une liste ordonnée des nom des atomes selon des data définies est l'insert dans un conteneur parent choisi
     * @param {*} data data sous forme json / Doit comporté le `nom` & `id` de l'élément
     * @param {*} Kinship Défini le parent qui contiendra la liste des éléments
     */
    function creatNewListName(data, kinship)
    {
       ulResultSearch = document.createElement('ul')
       let icrementTab = 0;
       data.forEach(article => {
           let li = document.createElement('li');


           li.innerHTML = article.titre_article

           ulResultSearch.role="listbox"
           li.innerHTML = `<a href="${document.location.origin}/kawa/produit/${article.id_article}">${li.innerHTML.replace(strUcFirst(inputSearch.value),'<span class="strBolder">'+strUcFirst(inputSearch.value)+'</span>')}</a>`
           let aChild = li.firstChild

           ulResultSearch.appendChild(li)
           icrementTab++;
           });

           kinship.appendChild(ulResultSearch);
    }

    /** Si la personne reprend la sourie on annule le comportement du clavier */
    inputSearch.addEventListener('click', (event)=>{
       indexSelect =  -1
       containeResultSearch.classList.remove('hidden')
       containeResultSearch.scrollTop = 0
   });

   /**
    * Si la personne utilise les flèches du clavier nous navigon dans l'autocompletion déjà charger
    */
    inputSearch.addEventListener('keydown', (event)=>{
       if(inputSearch.value.length >= 1)
       {
           
           let liNode = containeResultSearch.querySelectorAll('li');
           let indexwitness = indexSelect;

           function followingPositionLiSelected()
           {
               let posLi = liNode[indexSelect].offsetTop
               let sizeLi = liNode[indexSelect].clientHeight
               let sizeBox =containeResultSearch.clientHeight

               if(event.key === 'ArrowDown' && posLi+sizeLi >sizeBox)
               {
                   containeResultSearch.scrollTop = (posLi+sizeLi)-(sizeBox-5)
               }

               if(event.key === 'ArrowUp' && containeResultSearch.scrollTop > posLi)
               {
                   containeResultSearch.scrollTop = posLi
               }
           }
           
           if(event.key === 'ArrowDown')
           {
               if(indexwitness > -1)
               {
                   liNode[indexwitness].classList.remove('liOnFocus'); 
               }
               ++indexSelect;
               if(indexSelect >= liNode.length)
               {
                   indexSelect = 0;
               }
               liNode[indexSelect].classList.add('liOnFocus');

               followingPositionLiSelected()

               interuptSearch = true
               
           }
           else if(event.key === 'ArrowUp')
           {
               if(indexwitness > -1)
               {
                   liNode[indexwitness].classList.remove('liOnFocus'); 
               }
               --indexSelect;
               if(indexSelect >= 0)
               {
               liNode[indexSelect].classList.add('liOnFocus');

               followingPositionLiSelected()

               interuptSearch = true
               }
               else{
                   indexSelect = -1
               }
           }
           else if(event.key === 'Enter')
           {
               if(indexSelect > -1)
               {
               let newloc = liNode[indexSelect].firstChild.href
               window.location = newloc
               }
               else(
                   window.location.href = `${document.location.origin}/kawa/boutique/all?recherche=${inputSearch.value}`
               )
           }
           else{
               interuptSearch = false
               indexSelect =  -1;
           }     
       }
   })


   /**
    * Script de la barre de recherche
    * Donnée récupérer format JSON /valeur d'entrée Keypress caractère superieur à 1
    * JSON = 2 Objets retournées => Comprennant chacun deux attributs : nom, id
    *  - 'under'= 'le champ de recherche s'applique à l'interieur du nom'
    *  - 'begin'= 'le champ de recherche s'applique au début du nom'
    */
       inputSearch.addEventListener('keyup', (event) => {
           if(interuptSearch === false)
           {
               //Nettoyage des recherche précédente
               if(containeResultSearch.childNodes != null)
               {
                   let allHoldLi = containeResultSearch.querySelectorAll('ul');

                   allHoldLi.forEach(oldLi => {
                       oldLi.remove()
                   }); 
               }

               if(inputSearch.value.length >= 2)
               {
                event.preventDefault()
              
                    const dataSearch = new FormData
                    dataSearch.set('recherche', inputSearch.value)
              
                    fetch(`${document.location.origin}/kawa/Api/apiSearch.php`,{
                      method: 'POST',
                      body: dataSearch
                    }).then(response => response.json())
                   .then((response) =>{       
                           creatNewListName(response, containeResultSearch)
                   });

               }
           }
       });

   
   inputSearch.addEventListener('focusout', (event)=>{
       setTimeout(() => {
           if(inputSearch.value.length > 0)
       {
       containeResultSearch.classList.add('hidden')
       }
       }, 100);
       
   })

   containeResultSearch.addEventListener("mouseover", function( event ) {
       let changefocus = containeResultSearch.querySelector('.liOnFocus')
       if(changefocus != null)
       {
           changefocus.classList.remove('liOnFocus')
       }
   });

});