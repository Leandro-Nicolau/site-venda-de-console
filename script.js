const botaoMenu = document.getElementById("menu-toggle");
const menu = document.getElementById("menu");

if (botaoMenu && menu) {

    botaoMenu.addEventListener("click", function() {

        menu.classList.toggle("menu-aberto");

    });

}






let carrinho = JSON.parse(localStorage.getItem("carrinho")) || [];
function adicionarAoCarrinho(idProduto, nomeProduto, precoProduto) {

    const produto = {
        id: idProduto,
        nome: nomeProduto,
        preco: precoProduto,
        imagem: ""
    };

    carrinho.push(produto);

    localStorage.setItem("carrinho", JSON.stringify(carrinho));

    atualizarContador();

    alert(produto.nome + " foi adicionado ao carrinho!");
}
function atualizarContador() {

    const contador = document.getElementById("contador-carrinho");

    if (contador) {
        contador.textContent = carrinho.length;
    }
}

atualizarContador();

const formularioCompra = document.getElementById("form-compra");

if (formularioCompra) {

    formularioCompra.addEventListener("submit", function(event) {

        if (carrinho.length === 0) {
            event.preventDefault();
            alert("Seu carrinho está vazio!");
            return;
        }

        const carrinhoDados = document.getElementById("carrinho-dados");

        carrinhoDados.value = JSON.stringify(carrinho);

    });

}

const listaCarrinho = document.getElementById("lista-carrinho");

if (listaCarrinho) {

    carrinho.forEach(function(produto, indice) {

        const item = document.createElement("div");

        item.innerHTML = `
            ${produto.imagem ? `<img src="${produto.imagem}" alt="${produto.nome}">` : ""}
            <h3>${produto.nome}</h3>
            <p>R$ ${produto.preco.toFixed(2).replace(".", ",")}</p>
            <button onclick="removerDoCarrinho(${indice})">
                Remover
            </button>
        `;

        listaCarrinho.appendChild(item);
    });

}
function removerDoCarrinho(indice) {

    carrinho.splice(indice, 1);

    localStorage.setItem("carrinho", JSON.stringify(carrinho));

    location.reload();
}
const formulario = document.getElementById("form-contato");

if (formulario) {

    formulario.addEventListener("submit", function(event) {

        event.preventDefault();

        const nome = document.getElementById("nome").value;
        const email = document.getElementById("email").value;
        const mensagem = document.getElementById("mensagem").value;

        const mensagemFormulario = document.getElementById("mensagem-formulario");

        if (nome === "" || email === "" || mensagem === "") {

            mensagemFormulario.textContent = "Preencha todos os campos.";

        } else if (!email.includes("@")) {

            mensagemFormulario.textContent = "Digite um e-mail válido.";

        } else {

            mensagemFormulario.textContent = "Mensagem enviada com sucesso!";

        }

    });

}