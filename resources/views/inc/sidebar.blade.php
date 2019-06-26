
<form name="filterProducts" class="form-inline" method="GET" action="{{ route('products') }}">
    <div id="sidebar" class="span3">

        <!-- Search -->
        <div class="col-md-12" style="margin-bottom: 20px; float: left;">
            <div class="form-inline navbar-search">
                <input type="text" placeholder="Search by Name" name="searchTerm">
                <button type="submit" id="submitButton" class="btn btn-success">Go</button>
            </div>
        </div>
        <br>
        
        <h4>CATALOG</h4>
        <div class="thumbnail">
            <div class="caption">
                <h5>Category</h5>
                <h4><a href="{{ route('products') }}" style="color: deeppink;">All Products</a></h4>
                @foreach($categories as $scategory)
                <label class="check-label">                 
                    <input onChange="this.form.submit();" type="checkbox" name="category" class="chk" id="{{ $scategory->name }}" value="{{ $scategory->name }}"/>
                    {{ $scategory->name }} ({{ $scategory->products->count() }})
                    <span id="addchk" class="checkmark <?php echo ($category == $scategory->name)? 'pink':''; ?>"></span>                   
                </label>
                <br/>
                @endforeach
            </div>
        </div>
        <br>
        {{-- <div class="thumbnail">
            <div class="caption">
                <h5>Flower by Type</h5>
                <label class="check-label"> Roses 12
                    <input type="checkbox">
                    <span class="checkmark"></span>
                </label>
                <label class="check-label"> Lilies 19
                    <input type="checkbox">
                    <span class="checkmark"></span>
                </label>
                <label class="check-label"> Daisies 19
                    <input type="checkbox">
                    <span class="checkmark"></span>
                </label> 
                <label class="check-label"> Tulips 8
                    <input type="checkbox">
                    <span class="checkmark"></span>
                </label>
            </div>
        </div>
        <br>
        <div class="thumbnail">
            <div class="caption">
                <h5>Size</h5>
                <label class="check-label"> Small
                    <input type="checkbox">
                    <span class="checkmark"></span>
                </label>
                <label class="check-label"> Medium
                    <input type="checkbox">
                    <span class="checkmark"></span>
                </label>
                <label class="check-label"> Large
                    <input type="checkbox">
                    <span class="checkmark"></span>
                </label>
            </div>
        </div>
        <br>
        <div class="thumbnail">
            <div class="caption">
                <h5>Color</h5>
                <label class="check-label"> <span class="k-cir"></span>
                    <input type="checkbox">
                    <span class="checkmark"></span>
                </label>
                <label class="check-label"> <span class="k-cir k-cir-1"></span>
                    <input type="checkbox">
                    <span class="checkmark"></span>
                </label>
                <label class="check-label"> <span class="k-cir k-cir-2"></span>
                    <input type="checkbox">
                    <span class="checkmark"></span>
                </label>
            </div>
        </div>
        <br> --}}
        <div class="thumbnail">
            <div class="caption">
                <h5>Price Range (Rs)</h5>
                <input id="minPrice" placeholder="min" name="minPrice" type="number" value="<?php if(isset($minPrice)){echo $minPrice;} ?>" style="width: 80px; float: left; margin: 0.4rem;">
                <input id="maxPrice" placeholder="max" name="maxPrice" type="number" value="<?php if(isset($maxPrice)){echo $maxPrice;} ?>" style="width: 80px; float: left; margin: 0.4rem;">
                <input name="filterPrice" value="Apply filters" type="submit" class="btn btn-default" style="width: 100px; margin: 0.4rem;">            
                <input type="hidden" name="oldSearchTerm" value="<?php if(isset($searchTerm)){echo $searchTerm;} ?>">
                <input type="hidden" name="oldSortTerm" value="<?php if(isset($sortTerm)){echo $sortTerm;} ?>">
                <input type="hidden" name="oldMinPrice" value="<?php if(isset($minPrice)){echo $minPrice;} ?>">
                <input type="hidden" name="oldMaxPrice" value="<?php if(isset($maxPrice)){echo $maxPrice;} ?>">                
            </div>
        </div>
    </div>
</form>