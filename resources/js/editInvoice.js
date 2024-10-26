export default (invoice) => (
    {
    open: false,
    selectedCustomer: invoice.customer.company_name || '',
    selectedCustomerId: invoice.customer_id || '',
    items: invoice.invoice_items.map((item, index) => (console.log(item), {
        seqNo: index + 1,
        particulars: item.particulars,
        qty: item.qty,
        rate: item.rate,
        amount: item.amount,
        markedToDelete: false,
        vat_perc: item.vat_perc
    })),
    invoice_no: invoice.invoice_no,
    invoice_date: invoice.invoice_date ? invoice.invoice_date.split('T')[0] : '',
    terms: invoice.terms,
    reference: invoice.reference,
    gross_amt: invoice.gross_amt,
    vat_amt: invoice.vat_amt,
    net_amt: invoice.net_amt,
    errors: {},

    addItem() {
        this.items.push({ seqNo: this.items.length + 1, particulars: '', qty: 0, rate: 0, amount: 0, markedToDelete: false, vat_perc: 21 });
    },

    deleteItem(item) {
        item.markedToDelete = true;
    },

    calcAmount(item) {
        item.amount = item.qty * item.rate || 0;
    },

    highlightErrors() {
        this.errors = {};
        if (!this.selectedCustomerId) this.errors.customer_id = true;
        if (!this.invoice_date) this.errors.invoice_date = true;
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
    updateInvoice() {
        this.highlightErrors();
        if (Object.keys(this.errors).length > 0) return;

        let vatApplicableAmt = this.items
            .filter(item => !item.markedToDelete)
            .reduce((total, item) => total + item.amount * (item.vat_perc / 100), 0);

        this.gross_amt = this.items
            .filter(item => !item.markedToDelete)
            .reduce((total, item) => total + item.amount, 0);

        this.vat_amt = vatApplicableAmt;
        this.net_amt = this.gross_amt + this.vat_amt;

        // Prepare data to be updated
        const invoiceData = {
            customer_id: this.selectedCustomerId,
            invoice_no: this.invoice_no,
            invoice_date: this.invoice_date,
            terms: this.terms,
            reference: this.reference,
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
        console.log({invoiceData});
        // Send update request
        fetch(`/invoices/${invoice.id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(invoiceData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'invoice-updated') {
                window.location.href = '/invoices';
            } else {
                alert('There was an issue updating the invoice.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while updating the invoice.');
        });
    }
});
