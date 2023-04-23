import FroalaEditor from 'froala-editor';

// Froala Plugins
import "froala-editor/js/plugins/lists.min.js";
import "froala-editor/js/plugins/align.min.js";
import "froala-editor/js/plugins/code_beautifier.min.js";
import "froala-editor/js/plugins/code_view.min.js";
import "froala-editor/js/plugins/colors.min.js";
import "froala-editor/js/plugins/font_size.min.js";
import "froala-editor/js/plugins/link.min.js";
import "froala-editor/js/plugins/paragraph_format.min.js";
import "froala-editor/js/plugins/paragraph_style.min.js";
import "froala-editor/js/plugins/inline_style.min.js";
import "froala-editor/js/plugins/fullscreen.min.js";
import "froala-editor/js/plugins/quote.min.js";

// Froala Styles
import "froala-editor/css/froala_editor.pkgd.css";
import "froala-editor/css/froala_style.css";
import "froala-editor/css/plugins.pkgd.css";

export default class WysiwygEditor extends HTMLTextAreaElement {
    connectedCallback() {
        FroalaEditor(this);
    }
}
