import FroalaEditor from 'froala-editor';
import 'froala-editor/css/froala_editor.pkgd.min.css';
import 'froala-editor/css/froala_style.min.css';

// Load your languages
import 'froala-editor/js/languages/fr.js';

// Load all plugins, or specific ones
// import 'froala-editor/js/plugins.pkgd.min.js';
import 'froala-editor/css/plugins.pkgd.min.css';
import 'froala-editor/js/plugins/align.min';
import 'froala-editor/js/plugins/char_counter.min';
import 'froala-editor/js/plugins/colors.min';
import 'froala-editor/js/plugins/font_family.min';
import 'froala-editor/js/plugins/font_size.min';
import 'froala-editor/js/plugins/lists.min';
import 'froala-editor/js/plugins/link.min';
import 'froala-editor/js/plugins/paragraph_format.min';
window.FroalaEditor = FroalaEditor;

function froalaDisplayError(p_editor, error ) {
    alert(`Error ${error.code}: ${error.message}`);
}

window.froalaDisplayError = froalaDisplayError;