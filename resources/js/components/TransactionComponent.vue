<script>
    export default {
        mounted() {
            this.loading = true
            setTimeout(() => this.fetchTransactions(), 1000)  
        },
        data(){
            return {
                transactions: [],
                transaction: {
                    account_id: '',
                    transaction_to: '',
                    amount: '',
                    remarks: '',
                },
                transaction_id: '',
                pagination:{},
                edit:false,
                showTransactionForm:false,
            }

        },
        methods: {
            fetchTransactions(){
                fetch('api/transactions')
                .then(res => res.json())
                .then( res => {
                    this.transactions = res.data
                })
            },
            saveTransaction(){
                let formData = {
                    account_id : this.transaction.account_id,
                    transaction_to : this.transaction.transaction_to,
                    amount : this.transaction.amount,
                    remarks : this.transaction.remarks,
                }

                let method = !this.account_id ? 'post' : 'put'
                let url = `api/transactions`

                axios.post(url, formData).then(res => {
                        alert(res.data.message)
                        this.fetchTransactions()
                        
                        this.showTransactionForm = false
                        this.transaction.account_id = ''
                        this.transaction.transaction_to = ''
                        this.transaction.amount = ''
                        this.transaction.remarks = ''
                    }).catch(error => {
                        this.loading = false  
                        if(!('errors' in error)) {
                            alert(error.message)                        
                        }
                    });
                
            },

            
            toggoleTransactionForm(){
                this.showTransactionForm = !this.showTransactionForm
            },
            closeTransactionForm(){
                //this.account_id = ''
                this.showTransactionForm = false
            }
        },
    }
</script>