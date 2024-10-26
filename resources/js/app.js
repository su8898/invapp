import './bootstrap';

import Alpine from 'alpinejs';
import createInvoice from './createInvoice';
import editInvoice from './editInvoice';

Alpine.data('createInvoice', createInvoice);
Alpine.data('editInvoice', editInvoice);

window.Alpine = Alpine;

Alpine.start();
