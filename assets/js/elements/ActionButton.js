

export default class ActionButton extends HTMLElement {

    constructor() {
        super();
    }

    connectedCallback() {

        const csrfToken = this.getAttribute('data-csrf-token');
        const id = csrfToken.substring(0, 10);

        const formHtml = "\n<form action='" + this.getAttribute('data-uri') + "' method='POST' name='delete_item' style='display:none' id='"+id+"'>\n" +
            "<input type='hidden' name='_method' value='" + this.getAttribute('data-method') + "'>\n" +
            "<input type='hidden' name='_token' value='" + csrfToken + "'>\n" +
            '</form>\n';
        const append = () => {
            if (!this.querySelector('form')) {
                return formHtml;
            } else { return '' }
        };
        this.insertAdjacentHTML('afterend', append());
        this.setAttribute('href', '#')
        this.setAttribute('style', 'cursor:pointer;')
        this.setAttribute('onclick', '$(this).find("form").submit();');

        // const form = document.querySelector('#'+id);

        this.addEventListener('click', this.handleClick);
    }

    handleClick(e) {
        e.preventDefault();
        if (confirm('Are you sure you want to delete this element ?')) {
            this.nextElementSibling.submit();
        }

    }
}