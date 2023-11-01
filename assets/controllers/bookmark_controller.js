import { Controller } from "@hotwired/stimulus";
import { jsonFetch } from "../js/functions/api";

export default class extends Controller {

    static classes = ['bookmarked', 'loading'];
    static targets = ['btn'];
    static values = {
        bookmarked: Boolean,
        route: String,
        user: Number,
        job: Number
    };

    connect() {
        console.log('Bookmark Controller');
    }

    async toggle(event) {
        const response = await jsonFetch(this.routeValue, {
            method: 'POST'
        });

        console.log(response);
        this.bookmarkedValue = response.bookmarked;
    }

    bookmarkedValueChanged(event) {
        console.log('BookmarkedValueChanged', this.bookmarkedValue);
        if (this.bookmarkedValue) {
            this.element.classList.add(this.bookmarkedClass);
        } else {
            this.element.classList.remove(this.bookmarkedClass);
        }
    }
}
