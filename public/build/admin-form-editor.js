"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["admin-form-editor"],{

/***/ "./assets/admin/admin-form-editor.js":
/*!*******************************************!*\
  !*** ./assets/admin/admin-form-editor.js ***!
  \*******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var core_js_modules_es_array_concat_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! core-js/modules/es.array.concat.js */ "./node_modules/core-js/modules/es.array.concat.js");
/* harmony import */ var core_js_modules_es_array_concat_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_array_concat_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var froala_editor__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! froala-editor */ "./node_modules/froala-editor/js/froala_editor.min.js");
/* harmony import */ var froala_editor__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(froala_editor__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var froala_editor_css_froala_editor_pkgd_min_css__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! froala-editor/css/froala_editor.pkgd.min.css */ "./node_modules/froala-editor/css/froala_editor.pkgd.min.css");
/* harmony import */ var froala_editor_css_froala_style_min_css__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! froala-editor/css/froala_style.min.css */ "./node_modules/froala-editor/css/froala_style.min.css");
/* harmony import */ var froala_editor_js_languages_fr_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! froala-editor/js/languages/fr.js */ "./node_modules/froala-editor/js/languages/fr.js");
/* harmony import */ var froala_editor_js_languages_fr_js__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(froala_editor_js_languages_fr_js__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var froala_editor_css_plugins_pkgd_min_css__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! froala-editor/css/plugins.pkgd.min.css */ "./node_modules/froala-editor/css/plugins.pkgd.min.css");
/* harmony import */ var froala_editor_js_plugins_align_min__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! froala-editor/js/plugins/align.min */ "./node_modules/froala-editor/js/plugins/align.min.js");
/* harmony import */ var froala_editor_js_plugins_align_min__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(froala_editor_js_plugins_align_min__WEBPACK_IMPORTED_MODULE_6__);
/* harmony import */ var froala_editor_js_plugins_char_counter_min__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! froala-editor/js/plugins/char_counter.min */ "./node_modules/froala-editor/js/plugins/char_counter.min.js");
/* harmony import */ var froala_editor_js_plugins_char_counter_min__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(froala_editor_js_plugins_char_counter_min__WEBPACK_IMPORTED_MODULE_7__);
/* harmony import */ var froala_editor_js_plugins_colors_min__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! froala-editor/js/plugins/colors.min */ "./node_modules/froala-editor/js/plugins/colors.min.js");
/* harmony import */ var froala_editor_js_plugins_colors_min__WEBPACK_IMPORTED_MODULE_8___default = /*#__PURE__*/__webpack_require__.n(froala_editor_js_plugins_colors_min__WEBPACK_IMPORTED_MODULE_8__);
/* harmony import */ var froala_editor_js_plugins_font_family_min__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! froala-editor/js/plugins/font_family.min */ "./node_modules/froala-editor/js/plugins/font_family.min.js");
/* harmony import */ var froala_editor_js_plugins_font_family_min__WEBPACK_IMPORTED_MODULE_9___default = /*#__PURE__*/__webpack_require__.n(froala_editor_js_plugins_font_family_min__WEBPACK_IMPORTED_MODULE_9__);
/* harmony import */ var froala_editor_js_plugins_font_size_min__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! froala-editor/js/plugins/font_size.min */ "./node_modules/froala-editor/js/plugins/font_size.min.js");
/* harmony import */ var froala_editor_js_plugins_font_size_min__WEBPACK_IMPORTED_MODULE_10___default = /*#__PURE__*/__webpack_require__.n(froala_editor_js_plugins_font_size_min__WEBPACK_IMPORTED_MODULE_10__);
/* harmony import */ var froala_editor_js_plugins_lists_min__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! froala-editor/js/plugins/lists.min */ "./node_modules/froala-editor/js/plugins/lists.min.js");
/* harmony import */ var froala_editor_js_plugins_lists_min__WEBPACK_IMPORTED_MODULE_11___default = /*#__PURE__*/__webpack_require__.n(froala_editor_js_plugins_lists_min__WEBPACK_IMPORTED_MODULE_11__);
/* harmony import */ var froala_editor_js_plugins_link_min__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(/*! froala-editor/js/plugins/link.min */ "./node_modules/froala-editor/js/plugins/link.min.js");
/* harmony import */ var froala_editor_js_plugins_link_min__WEBPACK_IMPORTED_MODULE_12___default = /*#__PURE__*/__webpack_require__.n(froala_editor_js_plugins_link_min__WEBPACK_IMPORTED_MODULE_12__);
/* harmony import */ var froala_editor_js_plugins_paragraph_format_min__WEBPACK_IMPORTED_MODULE_13__ = __webpack_require__(/*! froala-editor/js/plugins/paragraph_format.min */ "./node_modules/froala-editor/js/plugins/paragraph_format.min.js");
/* harmony import */ var froala_editor_js_plugins_paragraph_format_min__WEBPACK_IMPORTED_MODULE_13___default = /*#__PURE__*/__webpack_require__.n(froala_editor_js_plugins_paragraph_format_min__WEBPACK_IMPORTED_MODULE_13__);



 // Load your languages

 // Load all plugins, or specific ones
// import 'froala-editor/js/plugins.pkgd.min.js';










window.FroalaEditor = (froala_editor__WEBPACK_IMPORTED_MODULE_1___default());

function froalaDisplayError(p_editor, error) {
  alert("Error ".concat(error.code, ": ").concat(error.message));
}

window.froalaDisplayError = froalaDisplayError;

/***/ })

},
/******/ __webpack_require__ => { // webpackRuntimeModules
/******/ var __webpack_exec__ = (moduleId) => (__webpack_require__(__webpack_require__.s = moduleId))
/******/ __webpack_require__.O(0, ["vendors-node_modules_core-js_internals_array-species-create_js-node_modules_core-js_internals-076afc","vendors-node_modules_core-js_modules_es_array_concat_js-node_modules_froala-editor_js_languag-dfaad9"], () => (__webpack_exec__("./assets/admin/admin-form-editor.js")));
/******/ var __webpack_exports__ = __webpack_require__.O();
/******/ }
]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiYWRtaW4tZm9ybS1lZGl0b3IuanMiLCJtYXBwaW5ncyI6Ijs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7O0FBQUE7QUFDQTtDQUdBOztDQUdBO0FBQ0E7O0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0FDLE1BQU0sQ0FBQ0QsWUFBUCxHQUFzQkEsc0RBQXRCOztBQUVBLFNBQVNFLGtCQUFULENBQTRCQyxRQUE1QixFQUFzQ0MsS0FBdEMsRUFBOEM7RUFDMUNDLEtBQUssaUJBQVVELEtBQUssQ0FBQ0UsSUFBaEIsZUFBeUJGLEtBQUssQ0FBQ0csT0FBL0IsRUFBTDtBQUNIOztBQUVETixNQUFNLENBQUNDLGtCQUFQLEdBQTRCQSxrQkFBNUIiLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hc3NldHMvYWRtaW4vYWRtaW4tZm9ybS1lZGl0b3IuanMiXSwic291cmNlc0NvbnRlbnQiOlsiaW1wb3J0IEZyb2FsYUVkaXRvciBmcm9tICdmcm9hbGEtZWRpdG9yJztcclxuaW1wb3J0ICdmcm9hbGEtZWRpdG9yL2Nzcy9mcm9hbGFfZWRpdG9yLnBrZ2QubWluLmNzcyc7XHJcbmltcG9ydCAnZnJvYWxhLWVkaXRvci9jc3MvZnJvYWxhX3N0eWxlLm1pbi5jc3MnO1xyXG5cclxuLy8gTG9hZCB5b3VyIGxhbmd1YWdlc1xyXG5pbXBvcnQgJ2Zyb2FsYS1lZGl0b3IvanMvbGFuZ3VhZ2VzL2ZyLmpzJztcclxuXHJcbi8vIExvYWQgYWxsIHBsdWdpbnMsIG9yIHNwZWNpZmljIG9uZXNcclxuLy8gaW1wb3J0ICdmcm9hbGEtZWRpdG9yL2pzL3BsdWdpbnMucGtnZC5taW4uanMnO1xyXG5pbXBvcnQgJ2Zyb2FsYS1lZGl0b3IvY3NzL3BsdWdpbnMucGtnZC5taW4uY3NzJztcclxuaW1wb3J0ICdmcm9hbGEtZWRpdG9yL2pzL3BsdWdpbnMvYWxpZ24ubWluJztcclxuaW1wb3J0ICdmcm9hbGEtZWRpdG9yL2pzL3BsdWdpbnMvY2hhcl9jb3VudGVyLm1pbic7XHJcbmltcG9ydCAnZnJvYWxhLWVkaXRvci9qcy9wbHVnaW5zL2NvbG9ycy5taW4nO1xyXG5pbXBvcnQgJ2Zyb2FsYS1lZGl0b3IvanMvcGx1Z2lucy9mb250X2ZhbWlseS5taW4nO1xyXG5pbXBvcnQgJ2Zyb2FsYS1lZGl0b3IvanMvcGx1Z2lucy9mb250X3NpemUubWluJztcclxuaW1wb3J0ICdmcm9hbGEtZWRpdG9yL2pzL3BsdWdpbnMvbGlzdHMubWluJztcclxuaW1wb3J0ICdmcm9hbGEtZWRpdG9yL2pzL3BsdWdpbnMvbGluay5taW4nO1xyXG5pbXBvcnQgJ2Zyb2FsYS1lZGl0b3IvanMvcGx1Z2lucy9wYXJhZ3JhcGhfZm9ybWF0Lm1pbic7XHJcbndpbmRvdy5Gcm9hbGFFZGl0b3IgPSBGcm9hbGFFZGl0b3I7XHJcblxyXG5mdW5jdGlvbiBmcm9hbGFEaXNwbGF5RXJyb3IocF9lZGl0b3IsIGVycm9yICkge1xyXG4gICAgYWxlcnQoYEVycm9yICR7ZXJyb3IuY29kZX06ICR7ZXJyb3IubWVzc2FnZX1gKTtcclxufVxyXG5cclxud2luZG93LmZyb2FsYURpc3BsYXlFcnJvciA9IGZyb2FsYURpc3BsYXlFcnJvcjsiXSwibmFtZXMiOlsiRnJvYWxhRWRpdG9yIiwid2luZG93IiwiZnJvYWxhRGlzcGxheUVycm9yIiwicF9lZGl0b3IiLCJlcnJvciIsImFsZXJ0IiwiY29kZSIsIm1lc3NhZ2UiXSwic291cmNlUm9vdCI6IiJ9