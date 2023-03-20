import swal from "sweetalert2";

/**
     * Reuse configuration by creating a `Swal` instance.
     *
     * Example:
     * ```
     * const Toast = Swal.mixin({
     *   toast: true,
     *   position: 'top-end',
     *   timer: 3000,
     *   timerProgressBar: true
     * })
     * Toast.fire('Something interesting happened', '', 'info')
     * ```
     */

const Toast = Swal.mixin({
    timerProgressBar: true,
    timer: 1000,
    toast: true,
    position: 'top-end',
});

export Toast;