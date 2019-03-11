# **What is Smart Uber ?** #

Think about we have an customer, he want to buying a piece of iron and he will go to the ironmongery shop to buy the piece of iron, after that the iron Mongery will tell the warehouse to get some of irons or it could be the iron Mongery will searching the iron to the supplier, if the iron out of stock

**Here we got four department:**

**branch** => lets say this is a customer, like someone which looking for a piece of iron

**company** => and this department will helping customers Easier to search what they want, like the owner of the ironmongery shop

**provider** => this is Similar with warehouse people, they can provide goods which customers want or if the iron out of stock, they will searching for the other warehouse and we can call it the iron suppliers

**member** => this is the something that the customer wants

The main purpose of this package is easier for us to seek reinforcements, such as finding a taxi, workers, iron , and the other else.
This packages will help us to easier to integrate between Company and Provider department also.

# **Installation** #

Install the latest version via composer with


```

$ composer require smart-uber/core
```


Next, add your new provider to the providers array of `config/app.php`


```

'providers' => [

// ...
SmartUber\Core\Providers\CoreServiceProvider::class,
// ...
],
```


And don't forget to publish our config, type `php artisan vendor:publish --tag=core-config` command in terminal

**Now you're ready to start using the Smart uber in your application.**

# **Usage** #

### **Branch** ###

In the branch department you want to open requisition and tell the company that you need an reinforcements, use `openRequest` method: 


```

$company = new Company();
$branch = new Branch();
```


you will need to associate the branch with company first:


```

$branch->company()->associate($company);
$requisition = $branch->openRequest('Branch Requisition', 'This is my first requisition', '2017-03-13', '2017-03-20');
```


In the first parameter is subject, the second is description, third parameter is start date , fourth parameter is end date


### **Company** ###

After the branch has opening the requisition, company can be posting the requisition from branch using `postRequest` method:

when you post the requisition, company will auto generate `providerRequisition` model based on company is total providers.
    
Before that if you dont have any instance of provider model, we need to create some providers and associate it with company


```

$company = new Company();
$provider = new Provider();
$user = new User();
$provider->company()->associate($company);
$provider->user()->associate($user);
$company->save();
$provider->save();
$user->save();    
$requisition = $company->postRequest($requisition, '2017-03-21', '50.000', '100.000', RateType::HOURLY); // posting the branches requisition
```

The second parameter is recruitment date, athird parameter is min price, fourth parameter is max price , fifth parameter is rate type.
You also can sets the rate type such as `HOURLY`, `WEEKLY`, `MONTHLY`.

If you dont want to use the requisition from branch ,you can open your own requisition using `openRequest` method in company model:


```

$company->openRequest($branch, 'Company Requisition', 'This is my first requisition', '2017-03-13', '2017-03-20');
```


`Company` will need `Branch` model to open an requisition and `Company` also can close the requisition, using `closeRequest` method:


```

$company->closeRequest($requisition);
```


after company post the requisition and reposted by provider, of course the tender will have an applicant, the applicant also can be accepted and rejected by company. Then we can use `acceptApplicant` and `rejectApplicant` and the parameter will receive an instance of Applicant model:

### **Provider** ###

In the provider model we have 2 different providers such as external and internal providers.
External providers such as provider owned by companies whereas the internal provider not owned by the company

We also can check that the provider is internal provider or not, we can using `isInternal` method:


```

$provider->isInternal(); // return boolean
```


Then, after company posted the requisition, provider will receive an company requisition some kind of quotation and provider can choose to accept or not, you can use `acceptCompanyRequisition`, `rejectCompanyRequisition` and you also can cancel the requisition using `cancelCompanyRequisition` method

After branch is requesting what he want, company will help them by telling to the provider

So lets say a provider has many of member and the provider is the taxi manager and the member is the taxi driver, so here the taxi manager will tell the members that the company need a reinforcements and member will accept the requisition if they interested, so here we will use `openTender` method:

Before that, if you dont have any instance of member model, we need to create a member and associate it with provider

```

$member = new Member();
$user = new User();
$member->provider()->associate($provider);
$member->save();
$tender = $provider->openTender($requisition, RateType::HOURLY, 100.000, RateType::HOURLY); //Return tender
```

`Provider` will need an instance of the `Requisition` model to open an tender, the second paramter is rate type ,the third parameter is markup price, fourth parameter is markup rate type.
Rate type and Markup rate type is similar thing , you also can sets it to `WEEKLY` or `MONTHLY`.
  
Provider also can close and cancel tender ,we can using `cancelTender` and `closeTender` method, and just now we said that company can accept and reject application, provider also do it similar, but a bit different in here provider need to filter the applicant before the companies filter the application.

We can use `acceptApplicant` and `rejectApplicant` and the parameter will receive instance of Applicant model.

By default the global configuration provider `auto_accept` is sets to false, if you dont want provider to accept or reject application one by one, you can sets it into true, now the provider always be auto accept when the applicant is coming

### **Member** ###

So just now we talk about member is people which can provide an reinforcements, and member will see all the posted tender, but if member is interested with the tenders.
member also can apply the tender by using `applyTender` method:


```

$applicants = $member->applyTender($tender); // return Applicant model
```

And this will generate a `Applicant` model.

Member also can cancel the application ,and we can use `cancelApplication` method,
but sometimes you need to get the applicant from last time you applying the tender, we can using `applicant` method:


```

$member->applicant($tender); // return applicant model
```
  

# **Configuration** #

Configuration was designed to be as flexible as possible. You can set up defaults for all of your Eloquent models, and then override those settings for individual models.

By default, global configuration can be set in the `app/config/core_config.php` file. Here is an example configuration, with all the default settings shown:
  
  
```

return [
    'payment'          => SmartUber\Core\Payment::class,
    'match_maker'       => SmartUber\Core\MatchMaker::class,
    'auto_accept'          => false,
    'auto_push_notification'       => false
];
```


### **payment** ###

Of course not all of the project have same payment system , some of project need a distinct payment system, basicly this package are using global payment, if you want to override into your own payment system you can override the configuration in `Config/core_config.php` on payment property.

**How to call the payment method ?**

We can use `makePayment` method in Company model:
    
```

$company->makePayment();
```
This will call your payment system based on your configuration

### **match_maker** ###

Sometimes we dont want to all tenders can be seen by a member, and not all of members can see a tender, and also not all of members should be notified, by default we have an global match maker model is notified to all member.

We can notifying to some member by spesific,
example : that the provider only want to notifying all member that genders is a man. Because there is so many match making criteria, you also can try override our global Match maker with your Match maker model individually


### **auto_accept** ###

Sometimes we are dont want to accept all of the members one by one, by default configuration auto accept is sets to false, we can sets it true and the provider will always being auto accept all members without accepting it one by one.

### **auto_push_notification** ###

When you are posting the tender you would need to notify all the member, there was a requisition from company. If this option is sets to true , we dont need manually push the notification into member, or it sets to false, you may need to manually notifying to the all of the member , by using `pushNotification` method.
  
  
```

$provider->pushNotification($tender);// Will notify to all member were owned by this provider 
```