<x-app-layout>

    <div class="row">


        <div class="col-10">
            <h1 class="text-center mb-3">Mail To Subscriber</h1>
        </div>
        <div class="col-2"><a href="{{ route('sent-mail.index') }}" class="btn btn-primary">Go Back</a></div>
    </div>
    <div class="imageContainer mb-3">
        <form method="POST" action="{{ route('admin.send-email') }}" class="row" enctype="multipart/form-data">
            @csrf
            <div class="col-8 form-group">
                <div>
                    <label for="user_type"></label>
                    <input type="radio" name="user_type" value="3" @if($data->user_type == 3 || $data->user_type== '') checked="checked" @endif>&nbsp;Subscriber
                    <input type="radio" name="user_type" value="1" @if($data->user_type == 1) checked="checked" @endif>&nbsp;Buyer
                    <input type="radio" name="user_type" value="2" @if($data->user_type == 2) checked="checked" @endif>&nbsp;Seller
                </div>
                    
                  
                <div id="brand_category_country" style="display: none;">
                    <div>
                        <label for="select brand">Select Brand</label>
                        <select name="brand_name" class="form-control" multiple>
                        @if($data->user_type==1 || $data->user_type==2)
                            @foreach($brandlist as $brand)
                                <option value="{{ $brand->brand_id }}">{{ $brand->brand_name }}</option>
                            @endforeach
                        @endif
                        </select>
                    </div>
                    <div>
                        <label for="select categories">Select Category</label>
                        <select name="category_name" class="form-control" multiple>
                        @if($data->user_type==1 || $data->user_type==2)
                        @foreach($categorylist as $cat)
                            <option value="{{$cat->category_id}}">{{ $cat->category_name}}</option>
                        @endforeach
                        @endif
                        </select>
                    </div>
                    <div>
                        <label for="select countries">Select Country</label>
                        <select name="country_name" class="form-control" multiple>
                        @if($data->user_type==1 || $data->user_type==2)
                        @foreach($countrylist as $country)
                            <option value="{{ $country->country_id }}">{{ $country->country_name}}</option>
                        @endforeach
                        @endif
                        </select>
                    </div>
                </div>
                </div>
                <div id="select_subject_subscriber" style="display: none;">
                <div>
                    <label for="select subject">Select Subject</label>
                    <select name="compose_id" class="form-control">
                        <option value="">select subject</option>
                        @if($data->user_type==1 || $data->user_type==2)
                            <option value="{{ $composelist->mail_id }}">{{ $composelist->mail_subject}}</option>
                        @endif
                    </select>
                </div>

                <div>
                    <label for="select subject">Select Subscriber</label>
                    <select name="mail_list" class="form-control" multiple>
                        @if($data->user_type==1 || $data->user_type==2)
                        @foreach($subscriberlist as $subscribe)
                            <option value="{{ $subscribe->user_id }}">{{ $subscribe->first_name}} {{ $subscribe->first_name}}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
            <div>
            </div>
            <button class="btn btn-primary customSaveButton" type="submit">Sent Mail</button>
        </form>

    </div>
    <script>
        let table = new DataTable('#cmspageslist');
    </script>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
        const userTypeRadios = document.querySelectorAll('input[name="user_type"]');
        const brandCategoryCountryDiv = document.getElementById('brand_category_country');
        const selectSubjectSubscriberDiv = document.getElementById('select_subject_subscriber');

        // Function to show Subscriber fields and hide Buyer/Seller fields
        function showSubscriberFields() {
            brandCategoryCountryDiv.style.display = 'none';
            selectSubjectSubscriberDiv.style.display = 'block';
        }

        // Function to show Buyer/Seller fields and Subscriber fields
        function showAllFields() {
            brandCategoryCountryDiv.style.display = 'block';
            selectSubjectSubscriberDiv.style.display = 'block';
        }

        // Set default state to Subscriber
        showSubscriberFields();

        // Add event listener to each radio button
        userTypeRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value == 3) { // Subscriber selected
                    showSubscriberFields();
                } else { // Buyer or Seller selected
                    showAllFields();
                }
            });
        });
    });
</script>



</x-app-layout>
