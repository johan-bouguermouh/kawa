/* Set the width of the side navigation to 250px and the left margin of the page content to 250px */
function openNav() {
  console.log(window.location)
    // document.getElementById("mySidenav").style.width = "450px";
    const panier = document.getElementById("mySidenav")
    panier.classList.remove('sidenavMouveDown')
    panier.classList.add('sidenavMouveUp')
  }
  
  /* Set the width of the side navigation to 0 and the left margin of the page content to 0 */
  function closeNav() {
    // document.getElementById("mySidenav").style.width = "450px";
    const panier = document.getElementById("mySidenav")
    panier.classList.remove('sidenavMouveUp')
    panier.classList.add('sidenavMouveDown')
  }

  

  window.addEventListener("DOMContentLoaded", () => {
    let totalPrice = 0
    const ContentPanier = document.querySelector('.sidenav__content')

    function isertElement(element){
      const contentProduct = document.createElement('form')
      contentProduct.classList.add('poductPanier')
      contentProduct.innerHTML = `
      <img class="picturePanier" src="/kawa/public/assets/pictures/pictures_product/${element.image_article}" alt=""></img>
      <div class="infoPanier">
          <div class="firstInfoPanier">
            <p> ${element.titre_article}</p>
            <p>${element.prix_article} €</p>
          </div>
          <div class="selectQuatity">
            <div>
                <input name="id_article" value="${element.id_article}" type="hidden">
                <button class="buttonPanierUp" name="upQuantity" value="1" type="submit"> + </button>
                <div>
                  <p class="numberOfProductSelected">${element.quatitySelected}</p>
                </div>
                <button class="buttonPanierDown" name="downQuantity" value="1" type="submit"> - </button>
            </div>
                <button name="deleteProduct" type="submit"> <i class="fa-solid fa-trash"></i> </button>
          </div>
          <p>prix total : <span class="totalPriceforthisProduct">${element.prix_article*element.quatitySelected}</span> €</p>
      </div>
        `
        ContentPanier.append(contentProduct)
    }

    fetch(`${document.location.origin}/kawa/Api/apiPanier.php?findArticle=1`).then(response => response.json())
    .then((data) =>{       
      if(data.status === 200)
      {
      data.result.forEach(element => {
              isertElement(element)
              totalPrice += element.prix_article*element.quatitySelected;
            });
      
      const footerPanier = document.createElement('section')
      footerPanier.classList.add('footerPanier')
      footerPanier.innerHTML=`
        <p>Total tva incl : <span class="totalPrice">${Number.parseFloat(totalPrice).toFixed(2)}</span> €</p>
        <form action="" method="post">
            <input class="button" name="goDelivery" value="commandé" type="submit">
        </form>
      `
      ContentPanier.append(footerPanier)
      }
    /**
     * Change total of price and insert in footer nav
     * @param {string} operator, 'up' for increment || 'down' for decrement
     * @param {int} price, price of product
     */
      function changeTotalPrice(operator, price){
      const footerPanier = ContentPanier.lastElementChild
      totalPrice = operator === 'up' ? totalPrice = totalPrice + price :  totalPrice = totalPrice - price
      const spanToChange = footerPanier.querySelector('span[class=totalPrice]')
      spanToChange.innerHTML = `${Number.parseFloat(totalPrice).toFixed(2)}`
      }

      let indexOfForm = 0
      for (let i = 0; i < ContentPanier.children.length; i++) {
        const contentForm = ContentPanier.children[i].tagName === 'FORM' ?  ContentPanier.children[i] : null
        if(contentForm != null)
        {
       
        const thisProduct = data.result[indexOfForm];
        const buttonDelete = contentForm.querySelector('button[name=deleteProduct')
        const buttonDown = contentForm.querySelector('button[name=downQuantity')
        const buttonUp = contentForm.querySelector('button[name=upQuantity')
        const valueInput = contentForm.querySelector('p[class=numberOfProductSelected]')
        const totalValue = contentForm.querySelector('span[class=totalPriceforthisProduct]')
      
          buttonDelete.addEventListener('click',(event) => {
            event.preventDefault()
            fetch(`${document.location.origin}/kawa/Api/apiPanier.php?deleteProduct=1&id_article=${thisProduct.id_article}`).then(response => response.json())
            .then(data => data === 200 ? window.location.reload() : null)
          
          })

          buttonDown.addEventListener('click',(event) => {
            event.preventDefault()

            if(parseInt(valueInput.innerHTML) > 1){
              fetch(`${document.location.origin}/kawa/Api/apiPanier.php?downQuantity=1&id_article=${thisProduct.id_article}`).then(response => response.json())
              .then((data) =>{ valueInput.innerHTML = `${data}` })
              totalValue.innerHTML = `${thisProduct.prix_article*(parseInt(valueInput.innerHTML)-1)}`
              changeTotalPrice('down', thisProduct.prix_article)
            }
          })

          buttonUp.addEventListener('click', (event)=>{
            event.preventDefault()
            if(parseInt(valueInput.innerHTML) < thisProduct.sku){
              fetch(`${document.location.origin}/kawa/Api/apiPanier.php?upQuantity=1&id_article=${thisProduct.id_article}`).then(response => response.json())
              .then((data) =>{ valueInput.innerHTML = `${data}` })
              totalValue.innerHTML = `${thisProduct.prix_article*(parseInt(valueInput.innerHTML)+1)}`
              changeTotalPrice('up', thisProduct.prix_article)
            }
          })

          indexOfForm++;
        }
        
      }
      
    });

  });

