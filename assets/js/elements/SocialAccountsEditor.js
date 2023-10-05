import { closest, html } from '../functions/dom';
import { jsonFetchOrFlash } from '../functions/api';
import { enterKeyListener } from '../functions/keyboard';
import { flash } from './Alert'
// import Sortable from 'sortablejs';

function SocialAccount({ account, onUpdate, onRemove, onAdd, editPath }) {
    function deleteSocialAccount(e) {
        e.preventDefault();
        e.stopPropagation();
        const li = closest(e.currentTarget, 'li');
        li?.parentElement?.removeChild(li);
        onUpdate();
    }
    console.log(account);

    return html`
    <li data-title="${account.name}" class="row">
        <input type="text" class="form-control col" value="${account.name}" onblur=${onUpdate} />
        <input type="text" class="form-control col" value="${account.link}" onblur=${onUpdate} />
        <button type="button" onclick=${deleteSocialAccount} class="btn btn-sm btn-danger col-1">
            <i class="fa fa-trash"></i>
        </button>
    </li>
    `;
}

function AddButton({ placeholder, onAdd }) {
    console.log('AddButton clicked');
    const callback = function (e) {
        e.preventDefault();
        e.stopPropagation();
        const li = closest(e.currentTarget, 'li');
        const inputs = li.querySelectorAll('input');
        const inputName = inputs[0];
        const inputLink = inputs[1];
        onAdd(inputName?.value, inputLink?.value, li);
        inputName.value = '';
        inputLink.value = '';
        inputName.focus();
    }

    return html`
    <li class="row">
      <input type="text" class="form-control col" placeholder=${placeholder} onkeydown=${enterKeyListener(callback)} />
      <input type="text" class="form-control col" placeholder=${placeholder} onkeydown=${enterKeyListener(callback)} />
      <button type="button" onclick=${callback} class="btn btn-sm btn-success col-1">
            <i class="fa fa-plus"></i>
      </button>
    </li>
    `;
}

export class SocialAccountEditor extends HTMLTextAreaElement {
    constructor() {
        super();
        // this.sortables = [];
        this.updateInput = this.updateInput.bind(this);
        this.removeAccount = this.removeAccount.bind(this);
        this.addAccount = this.addAccount.bind(this);
        // this.sortableOptions = {
        //     group: 'nested',
        //     animation: 200,
        //     fallbackOnBody: true,
        //     swapThreshold: 0.65,
        //     filter: '',
        //     preventOnFilter: false,
        //     onEnd: this.updateInput
        // };
    }

    connectedCallback() {
        this.addEventListener('t:beforeSubmit', function (e) {
            console.log('t:beforeSubmit', e);
            this.updateInput();
        });
        this.editPath = this.getAttribute('endpoint-edit');
        console.log('Path', this.editPath);
        this.list = this.renderList()
        // this.bindSortable()
        this.setAttribute('hidden', 'true');
        this.insertAdjacentElement('beforebegin', this.list)
        // this.replaceWith(this.list)
        console.log('This', this);
    }


    /**
     * Construit la liste de chapitre
     *
     * @param {SocialAccount[]}
     * @return HTMLUListElement
     */
    renderList() {
        console.log('Val', this.value);
        const sas = JSON.parse(this.value)
        return html`
      <ul class="chapters-editor stack">
        ${sas.map(
            account =>
                html`
              <${SocialAccount}
                account=${account}
                onUpdate=${this.updateInput}
                onRemove=${this.removeAccount}
                onAdd="${this.addAccount}"
                editPath="${this.editPath}"
              />
            `
        )}
        <${AddButton} placeholder="Ajouter un chapitre" onAdd=${this.addAccount} />
      </ul>
    `
    }

    /**
     * @param {KeyboardEvent|MouseEvent} e
     */
    addAccount(name, link, li) {
        const account = {
            name,
            link
        }
        const accountLi = html`
      <${SocialAccount}
        account=${account}
        onUpdate=${this.updateInput}
        onRemove=${this.removeAccount}
        editPath=${this.editPath}
      />
    `
        li.insertAdjacentElement('beforebegin', accountLi)
        console.log(li);
        this.updateInput();
        // this.sortables.push(new Sortable(accountLi.querySelector('ul'), this.sortableOptions))
    }


    /**
   * Supprime un cours de la liste des chapitres
   *
   * @param {MouseEvent} e
   */
    async removeAccount(e) {
        e.preventDefault()
        if (e.currentTarget instanceof HTMLButtonElement) {
            const li = closest(e.currentTarget, 'li')
            li.parentElement.removeChild(li)
            this.updateInput()
        }
    }



    /**
     * Greffer le comportement sortablejs
     */
    bindSortable() {
        this.sortables = Array.from(this.list.querySelectorAll('ul')).map(u => {
            return new Sortable(u, this.sortableOptions)
        })
        this.sortables.push(
            new Sortable(this.list, {
                ...this.sortableOptions,
                group: 'parent'
            })
        )
    }



    /**
     * Met à jour le champs avec les nouvelles données
     *
     * @param {HTMLUListElement} ul
     * @param {HTMLTextAreaElement} input
     */
    updateInput() {
        console.log('List', this.list);
        const newAccounts = []
        Array.from(this.list.children).forEach(li => {
            // On ajoute le chapitre au tableau
            newAccounts.push({
                name: li.querySelectorAll('input')[0].value,
                link: li.querySelectorAll('input')[1].value,
            })
        });
        this.value = JSON.stringify(newAccounts);
        console.log('Val', this.value);
        jsonFetchOrFlash(this.editPath, {
            method: 'POST',
            body: {socialAccounts: newAccounts}
        }).then(res => {
            console.log('UpdateInput Res', res);
            flash('Success');
        }).catch(err => console.log(err));
    }

    disconnectedCallback() {
        // this.sortables.forEach(sortable => sortable.destroy())
        if (this.list.parentElement) {
            this.list.parentElement.removeChild(this.list)
        }
    }

}
