<script>
    export default {
        mounted() {
            this.loading = true
            setTimeout(() => this.fetchUser(), 1000) 
        },
        data(){
            return {
                name: '',
                email: '',
                password: '',
                confirmPassword: '',
            }

        },
        methods: {
            fetchUser(){
                axios.get('api/user')
                .then( res => {
                    this.name = res.data.name
                    this.email = res.data.email
                })
            },
            saveUser(){
            
                let formData = {
                    name : this.name,
                    email : this.email,
                    password : this.password,
                    confirmPassword : this.confirmPassword,
                }

                if(this.password !== this.confirmPassword){
                    alert('Password Mismatch')
                    return
                }

                let url = `api/user`

                axios({
                  method: 'post',
                  url: url,
                  data: formData,
                  validateStatus: (status) => {
                    return true; // I'm always returning true, you may want to do it depending on the status received
                  },
                }).catch(error => {
                    alert('Something Went Wrong')
                }).then(response => {
                    if(response.status === 200){
                        alert('Success')

                        this.password = ''
                        this.confirmPassword = ''
                    }else{
                        alert(response.data.error.message)
                    }
                });  
                
            },
        },
    }
</script>