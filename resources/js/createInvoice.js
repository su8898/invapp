export default () => ({
    open: false,
    selectedCustomer: '',
    selectedCustomerId: '',
    items: [{ seqNo: 1, particulars: '', qty: 0, rate: 0, amount: 0, markedToDelete: false, vatApplicable: true, vat_perc: 21 }],
    invoice_no: '',
    invoice_date: '',
    terms: '',
    reference: '',
    vat_no: '',
    gross_amt: 0,
    vat_amt: 0,
    net_amt: 0,
    errors: {}, // Track missing fields

    addItem() {
        this.items.push({ seqNo: this.items.length + 1, particulars: '', qty: 0, rate: 0, amount: 0, markedToDelete: false, vatApplicable: true, vat_perc: 21 });
    },

    deleteItem(item) {
        item.markedToDelete = true;
    },

    calcAmount(item) {
        if (isNaN(item.qty) || isNaN(item.rate) || item.qty === undefined || item.rate === undefined) {
            item.amount = 0;
        } else {
            item.amount = item.qty * item.rate;
        }
    },
    highlightErrors() {
        this.errors = {};
        if (!this.selectedCustomerId) this.errors.customer_id = true;
        if (!this.invoice_date) this.errors.invoice_date = true;
        console.log(this.errors)
    },
    get grossAmount() {
        return this.items.reduce((sum, item) => sum + item.amount, 0).toFixed(2);
    },
    get vatAmount() {
        return this.items.reduce((sum, item) => sum + (item.amount * (item.vat_perc/100)), 0).toFixed(2); // assuming VAT is 20%
    },
    get netAmount() {
        return (parseFloat(this.grossAmount) + parseFloat(this.vatAmount)).toFixed(2);
    },
    saveInvoice() {
        this.highlightErrors();
        if (Object.keys(this.errors).length > 0) {
            return;
        }

        // Calculate VAT applicable amount based on each item's vat_perc
        let vatApplicableAmt = this.items
            .filter(item => !item.markedToDelete)
            .reduce((total, item) => total + item.amount * (item.vat_perc / 100), 0);

        this.gross_amt = this.items
            .filter(item => !item.markedToDelete)
            .reduce((total, item) => total + item.amount, 0);

        this.vat_amt = vatApplicableAmt;
        this.net_amt = this.gross_amt + this.vat_amt;

        // Prepare invoice data
        const invoiceData = {
            customer_id: this.selectedCustomerId,
            invoice_no: this.invoice_no,
            invoice_date: this.invoice_date,
            terms: this.terms,
            reference: this.reference,
            vat_no: this.vat_no,
            gross_amt: this.gross_amt,
            vat_amt: this.vat_amt,
            net_amt: this.net_amt,
            items: this.items.filter(item => !item.markedToDelete).map(item => ({
                particulars: item.particulars,
                qty: item.qty,
                rate: item.rate,
                amount: item.amount,
                vat: item.amount * (item.vat_perc / 100),
                vat_perc: item.vat_perc,
                net: item.amount + (item.amount * (item.vat_perc / 100))
            }))
        };

        // Send data to the backend
        fetch('/invoices', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Ensure CSRF token is included
            },
            body: JSON.stringify(invoiceData)
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'invoice-created') {
                    window.location.href = '/invoices';
                } else {
                    alert('There was an issue creating the invoice.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while creating the invoice.');
            });
    }
});
