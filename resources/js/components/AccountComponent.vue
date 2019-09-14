<script>
    export default {
        mounted() {
            this.loading = true
            setTimeout(() => this.fetchAccounts(), 1000)  
        },
        data(){
            return {
                accounts: [],
                account: {
                    id: '',
                    balance: '',
                },
                account_id: '',
                pagination:{},
                edit:false,
            }

        },
        methods: {
            fetchAccounts(){
                fetch('api/accounts')
                .then(res => res.json())
                .then( data => {
                console.log(data)
                    this.accounts = res.data
                })
            }
        }
    }
</script>