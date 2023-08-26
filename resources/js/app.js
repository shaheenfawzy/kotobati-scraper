import "./bootstrap";
import "../css/app.css";
import axios from "axios";
import swal from "sweetalert";

const form = document.querySelector("form");

form.addEventListener("submit", (e) => {
    e.preventDefault();

    const url = document.querySelector("#bookInput").value;

    axios.get("/scrape", { params: { url: url } }).then((response) => {
        const data = response.data;

        if (!data.success) {
            swal({
                title: "Oops!",
                text: data.message,
                icon: "error",
                timer: 1500,
            });
        } else {
            showBook(data.resource);
        }
    });
});

const showBook = (book) => {
    const bookInfo = document.querySelector("#bookInfo");
    const title = document.querySelector("#bookTitle");
    const author = document.querySelector("#bookAuthor");
    const language = document.querySelector("#bookLanguage");
    const pagesCount = document.querySelector("#bookPagesCount");
    const size = document.querySelector("#bookSize");
    const downloadBtn = document.querySelector("#downloadBtn");

    title.textContent = book.title;
    author.textContent = book.author;
    language.textContent = book.language;
    pagesCount.textContent = book.pages_count;
    size.textContent = book.size;

    if (book.downloadable) {
        downloadBtn.setAttribute("href", book.downloadUrl);
        downloadBtn.classList.remove("d-none");
    }

    bookInfo.classList.remove("d-none");
};
