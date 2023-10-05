import { jsonFetch } from '@@/js/functions/api';
import { strToDom, createElement } from '@@/js/functions/dom';
import { flash } from '@@/js/elements/Alert';

class BookmarkButton extends HTMLElement {

    static get observedAttributes() { return ['bookmarked']; }

    constructor() {
        super();

        this.color = 'danger';
        this.icon = 'lni-heart-filled';
        // this.root = this.attachShadow({ mode: 'open' });
    }

    connectedCallback() {
        this.jobId = parseInt(this.dataset.job);
        this.bookmarks = parseInt(this.dataset.bookmarks);
        this.bookmarked = this.dataset.bookmarked;
        this.color = this.bookmarked ? 'danger' : 'gray';

        // this.root.appendChild(link);
        this.appendChild(
            this.getLinkElement(
                this.getIconElement(this.bookmarked),
                this.getCountSpanElement(this.bookmarks)
            ));
        console.log('Bookmarked ', this);

        this.addEventListener('click', this.handleClick)
    }

    async handleClick(event) {
        event.preventDefault();
        const route = this.getAttribute('route');


        const response = await jsonFetch(route);
        this.color = response.bookmarked ? 'danger' : 'gray';
        this.setAttribute('bookmarked', response.bookmarked);
        this.bookmarked = response.bookmarked;
        // this.querySelector('a').remove();
        // this.appendChild(this.getLinkElement(this.getIconElement(response.bookmarked)))
    }

    getLinkElement(icon, countSpan = null) {
        const link = createElement('a');
        link.setAttribute('class', 'p-3 border circle d-flex align-items-center justify-content-center bg-white ');
        if (this.bookmarked) {
            link.classList.remove('text-gray');
            link.classList.add('text-danger');
        } else {
            link.classList.remove('text-danger');
            link.classList.add('text-gray');
        }
        link.appendChild(icon);
        // link.appendChild(countSpan);

        return link;
    }

    getIconElement(bookmarked) {
        const icon = createElement('i');
        icon.setAttribute('class', 'position-absolute snackbar-wishlist lni');
        icon.classList.add(this.icon);

        return icon;
    }

    getCountSpanElement(count) {
        const countSpant = createElement('span');
        countSpant.textContent = count;

        return countSpant;
    }



    attributeChangedCallback(name, oldValue, newValue) {
        if (name === 'icon') {
            this.icon = this.getAttribute('icon');
        }

        if (name === 'bookmarked') {
            this.tooggleIconColor()

        }
    }

    tooggleIconColor() {
        if (this.bookmarked == true) {
            console.log('bookmarked = true', this.bookmarked);
            this.color = 'danger';
            this.querySelector('a').classList.remove('text-gray');
            this.querySelector('a').classList.add('text-danger');
        } else {
            console.log('bookmarked = true', this.bookmarked);
            this.color = 'gray';
            const link = this.firstElementChild;
            if (link) {
                link.classList.remove('text-danger');
                link.classList.add('text-gray');
            }

        }
    }

    disconnectedCallBack() {
        this.removeEventListener('click', this.handleClick);
    }
}

export default BookmarkButton;
