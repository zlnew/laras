import { Quasar, Dialog, Notify } from 'quasar';

import '@quasar/extras/material-icons/material-icons.css';
import 'quasar/src/css/index.sass';

const quasar = Quasar;

const plugins = {
  Dialog,
  Notify
}

export {
  quasar,
  plugins
};
