import { registerReactControllerComponents } from '@symfony/ux-react';
import './styles/app.css';

// start the Stimulus application
import './bootstrap';

registerReactControllerComponents(require.context('./react/controllers', true, /\.(j|t)sx?$/));

