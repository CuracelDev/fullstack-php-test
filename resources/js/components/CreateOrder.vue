<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create Order</div>

                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Provider</label>
                            <input type="email" class="form-control" id="exampleInputEmail1">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">HMO</label>
                            <input type="email" class="form-control" id="exampleInputEmail1">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Encounter Date</label>
                            <input type="email" class="form-control" id="exampleInputEmail1">
                        </div>
                        <div class="form-group">
                            <form>
                                <label for="exampleInputEmail1">Order Item</label>
                                <div class="form-row">
                                    <div class="col-md-3">
                                        <label for="exampleInputEmail1">name</label>
                                        <input type="email" class="form-control" id="exampleInputEmail1">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="exampleInputEmail1">Unit price</label>
                                        <input type="email" class="form-control" id="exampleInputEmail1">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="exampleInputEmail1">Qty</label>
                                        <input type="email" class="form-control" id="exampleInputEmail1">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="exampleInputEmail1">Sub total</label>
                                        <input type="email" class="form-control" id="exampleInputEmail1">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <button class="btn btn-primary">+</button>
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" placeholder="Sub total">
                                    </div>
                                </div>
                                <button type="submit" class="form-control btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
