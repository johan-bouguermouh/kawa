document.addEventListener("DOMContentLoaded", () => {
  /* Set the width of the side navigation to 250px and the left margin of the page content to 250px */
  function openNav() {
    console.log("in open");
    document.getElementById("mySidenav").style.width = "450px";
    document.getElementById("main").style.marginLeft = "450px";
  }

  /* Set the width of the side navigation to 0 and the left margin of the page content to 0 */
  function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
    document.getElementById("main").style.marginLeft = "0";
  }

  let panier = {
    form: document.querySelector(".poductPanier"),
    up: document.querySelector(".buttonPanierUp"),
    down: document.querySelector(".buttonPanierDown"),
    formDelete: document.querySelector(".formDelete"),
    delete: document.querySelector("button[name=deleteProduct]"),
    formDelivery: document.querySelector(".formDelivery"),
    goDelivery: document.querySelector("input[name=goDelivery]"),
  };

  let formData = new FormData(panier.form);
  const body = document.querySelector("body");

  let path = document.location.origin;

  async function cart() {
    formData.set("upQuantity", panier.up.value);
    formData.set("downQuantity", panier.down.value);
    const response = await fetch(
      path + "/kawa/app/Controllers/shoppingCartController.php",
      {
        method: "POST",
        body: formData,
      }
    );

    let data = response.json();

    let div = document.createElement("div");
    div.innerHTML = data;
    body.append(div);

    console.log(data);
  }

  panier.form.addEventListener("click", (e) => {
    e.preventDefault();
  });

  panier.up.addEventListener("click", (e) => {
    e.preventDefault();
    cart();
  });
});
