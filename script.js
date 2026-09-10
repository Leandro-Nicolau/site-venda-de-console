const botaoMenu = document.getElementById("menu-toggle");
const menu = document.getElementById("menu");

if (botaoMenu && menu) {

    botaoMenu.addEventListener("click", function() {

        menu.classList.toggle("menu-aberto");

    });

}
const produtos = [
    {
        id: 1,
        nome: "PlayStation 5",
        imagem: "ps5.png",
        preco: 3999.99,
        detalhes: "detalhes_ps5.html"
    },
    {
        id: 2,
        nome: "Xbox Series S",
        imagem: "xbox.png",
        preco: 3799.99,
        detalhes: "detalhes_xbox.html"
    },
    {
        id: 3,
        nome: "Nintendo Switch",
        imagem: "nintendo.png",
        preco: 2299.00,
        detalhes: "detalhes_nintendo.html"
    }
];

const catalogo = document.getElementById("catalogo");

if (catalogo) {

    produtos.forEach(function(produto) {

        const card = document.createElement("div");

        card.innerHTML = `
            <img src="${produto.imagem}" alt="${produto.nome}">
            <h3>${produto.nome}</h3>
            <p>R$ ${produto.preco.toFixed(2).replace(".", ",")}</p>

            <a href="${produto.detalhes}">Ver detalhes</a>

            <br><br>

            <button onclick="adicionarAoCarrinho(${produto.id})">
                Adicionar ao carrinho
            </button>
        `;

        catalogo.appendChild(card);

    });

}

let carrinho = JSON.parse(localStorage.getItem("carrinho")) || [];
function adicionarAoCarrinho(idProduto) {

    const produto = produtos.find(function(item) {
        return item.id === idProduto;
    });

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

const listaCarrinho = document.getElementById("lista-carrinho");

if (listaCarrinho) {

    carrinho.forEach(function(produto, indice) {

        const item = document.createElement("div");

        item.innerHTML = `
            <img src="${produto.imagem}" alt="${produto.nome}">
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