<script>
    const account = '/api/accounts'
    
    export default {
        mounted() {     
            this.fetchAccounts()
        },
        
        computed: {
            endpoint() {
                return account
            },

            fetchUrl() {
                return `${this.endpoint}/all`
            }
        },

        data() {
            return {
                loading: false, 
                accounts: [],
                id: null,  
                form: new Form({
                    name: '',
                }), 
            }
        },

        methods: {
            beforeOpen(event) {
                this.form.reset()
                this.id = null

                if(event.params){
                    let data = event.params
                    for(let key in this.form.data()) {
                        this.form[key] = data[key]
                    }

                    this.id = data.id
                }
            },

            async fetchFacilityTypes() {
                this.loading = true 
                let response = await axios.get(`${this.fetchUrl}${this.getURLQueryString()}`)
                this.facilityTypes = response.data
                this.loading = false
            },

            onClickHandleAction(...payload) {
                const [type, data] = payload

                if(type == 'edit') {
                    this.$modal.show(this.modal_name, data)
                } else if(type == 'delete') {
                    if(this.confirm()) {
                        this.delete(`${this.endpoint}/${data.id}`).then(bool => {
                            if(bool) {
                               this.facilityTypes.data.splice(this.facilityTypes.data.indexOf(data), 1) 
                            }
                        })
                    }
                }
            },

            onSubmitForm() {
                this.loading = true
                const formId = this.id
                let method = !formId ? 'post' : 'put'
                let url = !formId ? this.endpoint : `${this.endpoint}/${formId}`

                this.form[method](url).then(data => {
                    flash(data.message)
                    this.fetchFacilityTypes()                           
                    this.$modal.hide(this.modal_name)
                    this.loading = false
                }).catch(error => {
                    this.loading = false  
                    if(!('errors' in error)) {
                        flash(error.message, 'danger')                        
                    }
                });
            }
        }
    }
</script>