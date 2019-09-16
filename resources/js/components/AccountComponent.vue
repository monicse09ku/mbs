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
                    account_name: '',
                    account_desc: '',
                },
                account_id: '',
                pagination:{},
                edit:false,
                showAccountForm:false,
            }

        },
        methods: {
            fetchAccounts(){
                fetch('api/accounts')
                .then(res => res.json())
                .then( res => {
                    this.accounts = res.data
                })
            },
            saveAccount(){
                let formData = {
                    account_name : this.account.account_name,
                    account_desc : this.account.account_desc,
                    user_id : document.getElementById("user_id").value
                }

                let method = !this.account_id ? 'post' : 'put'
                let url = !this.account_id ? `api/accounts` : `api/accounts/${this.account_id}`

                if(this.account_id){
                    axios.put(url, formData).then(res => {
                        alert(res.data.message)
                        this.fetchAccounts()

                        this.showAccountForm = false
                        this.account.account_name = ''
                        this.account.account_desc = ''
                    }).catch(error => {
                        this.loading = false  
                        if(!('errors' in error)) {
                            alert(error.message)                        
                        }
                    });
                }else{
                    axios.post(url, formData).then(res => {
                        alert(res.data.message)
                        this.fetchAccounts()
                        
                        this.showAccountForm = false
                        this.account.account_name = ''
                        this.account.account_desc = ''
                    }).catch(error => {
                        this.loading = false  
                        if(!('errors' in error)) {
                            alert(error.message)                        
                        }
                    });
                }
                
            },

            EditAccount(data){
                this.showAccountForm = true
                this.account_id = data.id
                this.account.account_name = data.account_name
                this.account.account_desc = data.account_desc
            },

            deleteAccount(id) {
                if (confirm('Are You Sure?')) {
                    fetch(`api/accounts/${id}`, {
                        method: 'delete'
                    })
                    .then(res => res.json())
                    .then(data => {
                        alert('Accunt Removed');
                        this.fetchAccounts();
                    })
                    .catch(err => console.log(err));
                }
            },
            toggoleAccountForm(){
                this.showAccountForm = !this.showAccountForm
            },
            closeAccountForm(){
                this.account_id = ''
                this.showAccountForm = false
            }
        },
    }
</script>