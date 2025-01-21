<?php
/**
 * LockGroup
 *
 * PHP version 7.4
 *
 * @category Class
 * @package  OpenAPI\Client
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 */

/**
 * iLOQ Public API
 *
 * Public API for iLOQ 5 Series locking system.   # Introduction This is OpenApi documentation for iLOQ Public API.   Service is REST (Representational state transfer).  Protocol used to transport the data is HTTP and JSON is used for data transfer.  Below is important information and notes about some business related concepts that have already been covered in you iLOQ training.  ## Calendar reservations  Below is a chart that illustrates relations between calendars and network module components.  ![Calendar chart](/iLOQPublicApiDoc/images/iLOQ_API_Chart.png)  ## Time limits  <h3> General information </h3>  Time limits are used to define when a key has access to a lock. Time limits are stored in the key.  Terms explained  * Time limit slot is a memory slot in a key.  * Time profile is a time limit slot that has a weekly clock.  * Time limit title is a preconfigured time profile that can be added to a key  * Time limit data is the weekly clock of a time profile  <h4> Time limit slot </h4> A key's time limit slot is either the key's start date, end date or a time profile added to the key.   <h4> Time profile</h4> Time profile need to be preconfigured in the locking system before it can be added to a key. This is done by creating a TimeLimitTitle. When adding time profiles to a key, you need to provide the TimeLimitTitle_ID of the preconfigured time profile you want to add. Time profiles can be either fixed or editable.  <li>Fixed time profiles cannot be modified as they are being added to the key. </li>  <li>Editable time profiles can be modified as they are being added to the key.</li>      When adding fixed time profiles, the TimeLimitTitle start- and end dates and the weekly clocks need to be set with identical values to the preconfigured time profile.  * The weekly clock start- and end times are in milliseconds. You will need to convert the time to milliseconds when adding time profiles to a key.   <h4> Time limit title</h4> Time limit title can be either a fixed or editable time profile. You need to create a time limit title before you can add time profiles to a key.  **[POST /api/v2/TimeLimitTitles](#operation/TimeLimitTitles_Insert)**.  <h4> Time limit data</h4> Time limit data is the weekly clock of a time profile. Do not add time limit data to a time limit slots 0 or 1.   <h3>Limitations to be considered</h3>  Take into account that physical key has hardware limitations.  Depending on locks versions, keys have max 10 up to 23 memory slots. This limits how many time limits can be stored to the key. C5 locks require minimum firmware version 138 and D5 locks require minimum firmware version 135 to support over 10 time limits.  Memory slot usage * Start date takes one slot  * End date takes one slot  * Time profiles can take multiple slots     * Time profile start date takes one slot     * Time profile end date takes one slot     * Each time limit data takes one slot  <h3> Key start date and end date -- slots 0 and 1 </h3>  Key's start and end date are stored in slots 0 and 1. These slots cannot be modified with any other endpoint than **[PUT /api/v2/Keys/{id}/SecurityAccesses](#operation/Keys_UpdateSecurityAccesses)**.  Common use cases: - An employee's employment start and end date.  - The time period when a technician has access to a certain site. - A simple calendar reservations. For example, a single sports hall reservation on Friday 20.10.2023 from 19:00 to 23:00.  Example payload ``` {     \"TimeLimitSlots\": [         {             \"LimitDateLg\": \"2022-05-01T10:00:00\",             \"SlotNo\": 0         },         {             \"LimitDateLg\": \"2022-06-30T18:00:00\",             \"SlotNo\": 1         }     ] } ```   <h3>Key time profiles -- slot 2</h3>  Common use cases are for example: - Key holder makes a reservation in the calendar of a third party system and a time profile is added to the key. Time profile has start and end time. - Recurring calendar reservation. In addition to start and end time, a weekly clock is added to the time profile. - An employee transfered to a remote office for several days, but having access to office only on weekdays during office hours 08:00-16:00. - Access to an office is limited to weekdays between 07:00 and 17:00.  Example payload ``` {   \"TimeLimitSlots\": [         {             \"SlotNo\": 2,    \"TimeLimitTitle_ID\":\"84c737d4-121e-4e4b-87f1-0d869a3fb161\",    \"TimeLimitData\": [     {      \"EndTimeMS\": 62100000,      \"StartTimeMS\": 31500000,      \"WeekDayMask\": 16     },     {      \"EndTimeMS\": 57600000,      \"StartTimeMS\": 28800000,      \"WeekDayMask\": 31     }             ]         }     ] } ```  Example payload with start and end dates, fixed and editable time profiles. ``` {     \"TimeLimitSlots\": [         {             \"SlotNo\": 2,             \"TimeLimitData\": [                 {                     \"WeekDayMask\": 31,                     \"StartTimeMS\": 32400000,                     \"EndTimeMS\": 61200000                 }             ],             \"TimeLimitTitle_ID\": \"a4da99c5-102e-46f8-a64b-a51bcd5cb42b\",             \"TimeLimitTitleEndDateLg\": \"2022-06-15T19:30:00\",             \"TimeLimitTitleStartDateLg\": \"2022-06-01T04:00:00\"         },         {             \"SlotNo\": 2,             \"TimeLimitData\": [                 {                     \"WeekDayMask\": 31,                     \"EndTimeMS\": 57600000,                     \"StartTimeMS\": 28800000                                     }             ],             \"TimeLimitTitle_ID\": \"103287c6-0757-4dec-b993-7b3fd616ae77\",         },         {             \"LimitDateLg\": \"2022-05-01T10:00:00\",             \"SlotNo\": 0,         },         {             \"LimitDateLg\": \"2022-06-30T18:00:00\",             \"SlotNo\": 1,         }     ] } ```  Notes: - Remember to use correct slot numbers. SlotNo 0 is for start date, SlotNo 1 is for end date and SlotNo 2 is for time profiles. - Request datetimes in format \"yyyy-MM-ddTHH:mm:ss\" using in locking system time zone. - When editing time limit slots using **[PUT /api/v2/Keys/{id}/SecurityAccesses](#operation/Keys_UpdateSecurityAccesses)** endpoint, remember to include all the needed slots, including start date, end date and time profiles. <b>All the ones you omit will be deleted from the key.</b>     * Also, remember to include any used security access ids in the SecurityAccessIds array. <b>Otherwise they will be deleted from the key.</b> - For complex time limit configurations try use iLOQ 5 Series Manager create these time limits. Then request **[GET Keys/{id}/TimeLimitTitles](#operation/Keys_GetTimeLimits)** to see how payloads of keys' time profiles should be defined.  ## Phone keys  Phone keys can be created and programming tasks ordered through Public API.  Phone S50 app gets the programming task, programs itself, reports to server and after that, phone key is programmed.    ### Creating a new phone key to locking system  First create a new phone key by requesting **[POST api/v2/Keys](#operation/Keys_Insert)**.  <br> KeyTypeMask for phone key is 6 (S50 + PhoneKey).   Then update phone key information with phone number or email for registration SMS or email by requesting **[PUT api/v2/KeyPhones](#operation/KeyPhones_Update)**.   ### Setting main zone for the phone key  Check if main zone can be updated to the key by calling **[GET api/v2/Keys/{id}/CanUpdateMainZone](#operation/Keys_CanUpdateKeyMainZone)**. <br>  If main zone can be updated, update by calling **[POST api/v2/Keys/{id}/UpdateMainZone](#operation/Keys_UpdateKeyMainZone)**.   ### Adding access rights and time profiles for the phone key  Check first if access right can be added to the key by **[GET api/v2/Keys/{id}/SecurityAccesses/CanAdd](#operation/Keys_CanAddSecurityAccess)**.  <br>  Add access rights by calling **[POST api/v2/Keys/{id}/SecurityAccesses](#operation/Keys_InsertSecurityAccess)**. <br>  Check first if time profile can be added to the key by **[POST api/v2/Keys/{id}/TimeLimitTitles/CanAdd](#operation/Keys_CanAddTimeLimitTitle)**.  <br>  Add time profiles by calling **[POST api/v2/Keys/{id}/TimeLimitTitles](#operation/Keys_InsertTimeLimitTitle)**.   ### First time registration and ordering programming task  Check if programming can be ordered through API by calling **[GET api/v2/Keys/{id}/CanOrder](#operation/Keys_CanOrderKey)**.   <br>  Do this step always before ordering programming task. <br>  Order programming task for this new key by calling **[POST api/v2/Keys/{id}/Order](#operation/Keys_OrderKey)**.    ## External RFID tag keys  External RFID tag keys can be created and instantly programmed on server side through Public API.   ### Creating a new external tag key to locking system  First create a new external tag key by requesting **[POST api/v2/Keys](#operation/Keys_Insert)**. <br>   When creating a new key, KeyTypeMask for external RFID tag key is 384 (5 Series + Other than iLoq physical key).   ### Setting main zone for the external tag key  Check if main zone can be updated to the key by calling **[GET api/v2/Keys/{id}/CanUpdateMainZone](#operation/Keys_CanUpdateKeyMainZone)**. <br>  If main zone can be updated, update by calling **[POST api/v2/Keys/{id}/UpdateMainZone](#operation/Keys_UpdateKeyMainZone)**.   ### Adding access rights and time profiles for the external tag key  Check first if access right can be added to the key by **[GET api/v2/Keys/{id}/SecurityAccesses/CanAdd](#operation/Keys_CanAddSecurityAccess)**.  <br>  Add access rights by calling **[POST api/v2/Keys/{id}/SecurityAccesses](#operation/Keys_InsertSecurityAccess)**. <br>  Check first if time profile can be added to the key by **[POST api/v2/Keys/{id}/TimeLimitTitles/CanAdd](#operation/Keys_CanAddTimeLimitTitle)**.  <br>  Add time profiles by calling **[POST api/v2/Keys/{id}/TimeLimitTitles](#operation/Keys_InsertTimeLimitTitle)**.   ### Program the external RFID tag key  Check if programming can be ordered through API by calling **[GET api/v2/Keys/{id}/CanOrder](#operation/Keys_CanOrderKey)**.   <br>  Do this step always before ordering programming task. <br>  Order programming task for this new key by calling **[POST api/v2/Keys/{id}/Order](#operation/Keys_OrderKey)**.  RFID external tg gets programmed on the server side and is ready to use. After programming, KeyTypeMask for external RFID tag key is 400 (5 Series + Other than iLoq physical key + Classic Mifare rfid).   ## Returning the keys through API  Only S50 phone keys external RFID tag keys can be returned through API. Other types of keys require iLOQ 5 series Manager + programming key to return. Returning the key through API also deletes it from system.  Returning the key does not require separate **DELETE api/v2/Keys/{id}** request.   You can check if key can be returned through API by calling  **[GET api/v2/Keys/{id}/CanReturn](#operation/Keys_CanReturnKey)**.   If CanReturn reponse indicates that key can be returned with API then call **[POST api/v2/Keys/{id}/Return](#operation/Keys_ReturnKey)**.  If returning is not possible, see CanReturn response for further information.   Public API also supports deleting the keys. If key has been programmed or issued to programming it cannot be deleted from locking system anymore. Try instead returning. <br> Check first if key can be deleted calling **[GET api/v2/Keys/{id}/CanDelete](#operation/Keys_CanDeleteKey)**. <br> If response 0 Key can be deleted then proceed to call **[DELETE api/v2/Keys/{id}](#operation/Keys_Delete)**.  Any kind of non-programmed key type can be deleted throught API.    # Public API ## API Documentation This OpenApi 3.0 documentation is for Public API version 2 for 5 Series locking systems. Other locking systems should use version 1.  For other versions use this endpoint documentation: https://s10.iloq.com/iloqwsapi/help   OpenApi Json document can be used to generate client library in multiple programming languages (C#, java, javascript, etc.). For more information about swagger, visit https://swagger.io/  ## Usage  To use the API, you first need to make sure your locking system is API enabled. If it isn't enabled, an error will occur during login. You can view if your locking system is API enabled by logging into 5 Series Manager and going to Edit locking system information window and then selecting Settings tab. A checkbox will appear if API is enabled. For further assistance, please contact iLOQ. Contact information can be found at https://www.iloq.com/en/sales/iloq-sales-support/  Before starting, it is recommended to get familiar with the general idea and principles behind iLOQ's locking system. You can contact iLOQ to book a training course about the locking system and iLOQ Manager software. This training takes from half a day to a day. Here is also some reading about the locking system:  * S10: https://www.iloq.com/manual/en/s10/ * 5 Series: https://www.iloq.com/manual/en/5-series/  The API is a RESTful service. Endpoints can be called with simple HTTP calls and HTTP protocols are mapped to CRUD operations:  * GET will retrieve data * PUT updates data * POST inserts new data (sometimes also used to just retrieve data if complex parameter is required) * DELETE deletes data  # Getting started   **NOTE! Headers** <br> In all API calls, the Http header called **\"SessionId\"** is mandatory after step 2 Create session.<br> If you are using API Gateway, the header **\"x-api-key\"** must be included for every request.  Those header values you get from here:  * SessionID value from Create Session request * x-api-key value from API Developer Portal on My Dashboard-Page.   ## General process Using iLOQ Public API is a six step process.  ![Session handling chart](/iLOQPublicApiDoc/images/session_handling.png)   | Steps                  |                                                | | ---------------------- |------------------------------------------------| | 1. Resolve url         | Resolves which server url to use               | | 2. Create session      | Creates session                                | | 3. Get locking systems | Returns locking systems user has rights to use | | 4. Set locking system  | Logging to locking system                      | | 5. Call endpoints      | Use endpoints to manage locking system         | | 6. Kill session        | Terminates session after it's no longer needed |  ## 1. Resolve url First step is to get the correct url to use for the rest of the API calls.  Use your iLOQ Manager server url to call **[POST Url/GetUrl](#operation/Url_GetUrl)** endpoint with customer code. This endpoint returns you rest of url.  Calling this endpoint and resolving the url makes sure your application always uses the correct url to access the API.  Usually your iLOQ Manager server url is:  * https://s5.iloq.com/iloqws  * https://s5.iloq.de/iloqws  For example, after calling https://s5.iloq.com/iloqws/api/v2/Url/GetUrl endpoint, you might get https://s5.iloq.com/iloqwspool2/ as response. Use this new url to call rest of the API endpoints, e.g. https://s5.iloq.com/iloqwspool2/api/v2/CreateSession.  **NOTE!** If GetUrl returns a null or empty string, use original url that you used in **[POST Url/GetUrl](#operation/Url_GetUrl)** request to call rest of the endpoints. Do not skip this first part in your integration, even if **[POST Url/GetUrl](#operation/Url_GetUrl)** seems to always to return empty string.   ## 2. Create session After resolving the url, you can log in. Logging in must be done before calling any other API endpoint. This is done by calling **[POST CreateSession](#operation/Authentication_CreateSession)** endpoint with credentials.  | Credentials   | Description                        | | ------------- |----------------------------------- | | UserName      | User name                          | | Password      | Password                           | | CustomerCode  | Customer code                      | | ApiKey        | Leave empty for now                | | ApiSecret     | Leave empty for now                |   Call returns response token with SessionId and result which tells if the session creation was successful. This token has to be used in all API calls in Http header called \"SessionId\". ## 3. Get locking systems After retrieving session id successfully, you need to set the locking system user uses for the duration of this session. Persons, keys, locks and other resources are always linked to a locking system. Before they can be accessed, user must be authenticated to a locking system.    First you need to get all the locking systems user has rights to. Call **[GET LockGroups](#operation/LockGroups_GetAllLockGroups)** endpoint to get all locking systems that user has rights. Resultset contains one or more locking systems. If only one locking system is returned, that can be used directly. Otherwise show locking systems to end user and let user to choose locking system. ## 4. Set locking system To Authenticate to selected locking system call **[POST SetLockgroup](#operation/Authentication_SetLockgroup)** with the chosen locking system.   SetLockgroup returns user's permission rights. You can use this bit mask value to enable/disable certain actions in your software. For example, if your application is used to book times using a calendar and user doesn't have permission to edit calendars (CanEditCalendars (2251799813685248)), you can disable calendar edit controls.  Now user can call the rest of the API endpoints. ## 5. Call endpoints Call endpoints to manage locking system. ## 6. Kill session Lastly when you have finished using Public API endpoints, terminate session with **[GET KillSession](#operation/Authentication_KillSession)**. # Samples ## Common use cases These samples describe what endpoints and in which order to call them. These use cases do not provide parameters or responses.  * <a href=\"/iLOQPublicApiDoc/use_cases/iLOQ_BlacklistingKeys.html\" target=\"_blank\">Blocklisting keys</a> * <a href=\"/iLOQPublicApiDoc/use_cases/iLOQ_CalendarSecurityAccessGroup.html\" target=\"_blank\">Code access groups to calendar controls</a> * <a href=\"/iLOQPublicApiDoc/use_cases/iLOQ_SessionAndLogging.html\" target=\"_blank\">Creating session and logging to locking system</a> * <a href=\"/iLOQPublicApiDoc/use_cases/iLOQ_Calendars.html\" target=\"_blank\">Managing calendars and time controls</a> * <a href=\"/iLOQPublicApiDoc/use_cases/iLOQ_ManagingCalendarControlledDoors.html\" target=\"_blank\">Manage calendar controlled doors</a> * <a href=\"/iLOQPublicApiDoc/use_cases/iLOQ_ManagingCalendarControlledDoorsSecurityCode.html\" target=\"_blank\">Manage calendar controlled doors with code access groups</a> * <a href=\"/iLOQPublicApiDoc/use_cases/iLOQ_ManagingCodeAccesGroups.html\" target=\"_blank\">Manage code access groups</a> * <a href=\"/iLOQPublicApiDoc/use_cases/iLOQ_ManangingKeys.html\" target=\"_blank\">Managing keys</a> * <a href=\"/iLOQPublicApiDoc/use_cases/iLOQ_ManageKeysSecurityAccessesRemotely.html\" target=\"_blank\">Manage key's security accesses remotely</a> * <a href=\"/iLOQPublicApiDoc/use_cases/iLOQ_ManageLocksSecurityAccessesRemotely.html\" target=\"_blank\">Manage lock's security accesses remotely</a> * <a href=\"/iLOQPublicApiDoc/use_cases/iLOQ_ManagingPersons.html\" target=\"_blank\">Manage persons</a> * <a href=\"/iLOQPublicApiDoc/use_cases/iLOQ_OrderingPhoneKeys.html\" target=\"_blank\">Managing phone keys</a> * <a href=\"/iLOQPublicApiDoc/use_cases/iLOQ_OrderingRFIDKeys.html\" target=\"_blank\">Managing external RFID tags</a> * <a href=\"/iLOQPublicApiDoc/use_cases/iLOQ_ManagingSecurityAccesses.html\" target=\"_blank\">Manage security accesses</a> * <a href=\"/iLOQPublicApiDoc/use_cases/iLOQ_ManagingTimeLimits.html\" target=\"_blank\">Manage time profiles</a> * <a href=\"/iLOQPublicApiDoc/use_cases/iLOQ_S5KeyTimeProfiles.html\" target=\"_blank\">Manage time restrictions for iLOQ S5 keys</a>  ## UWP application Sample project is an UWP application written In C#. Project can be downloaded from **<a href=\"iLOQPublicApiDoc/use_cases/PublicApiUseCases.zip\">here</a>**. It shows you how to login to a locking system and it also covers these common use cases:  * Transferring person data from your system to iLOQ. * Making calendar reservations for common area, like laundry room or sauna. * Adding and configuring S5 keys for tenants. * Managing iLOQ S50 phone keys.  # Change history  ## Version 7.5  * New features      * Public API now supports creating, ordering, programming and returning external RFID tags       * Sample lists of requests can be found **[in samples section](#section/Samples/Common-use-cases)**.       * More about programming of external RFID tag keys can be found **[here](#section/Introduction/External-RFID-tag-keys)**.     * New endpoints     * **[GET Keys/{id}/LocationReporting](#operation/Keys_GetKeyLocationReportingInAuditTrail)**       * Query if phone key records the last known valid location of mobile device to audit trail during lock open event.     * **[PUT Keys/{id}/LocationReporting](#operation/Keys_SetKeyLocationReportingInAuditTrail)**       * Set if you want phone key to record the last known valid location of mobile device to audit trail during lock open event.  ## Version 7.4   * New endpoints     * **[POST Keys/{id}/TimeLimitTitles/CanAdd](#operation/Keys_CanAddTimeLimitTitle)**       * This endpoint will replace previous version that was HTTP GET method     * **[GET PersonRoles/{id}/SecurityAccesses](#operation/PersonRoles_GetSecurityAccessesByPersonRoleId)**       * Gets security accesses by person role  ## Version 7.1.8200.35003    * New features     * **[New webhook event for subcribing lock logs.](#section/Webhook-(Beta)/Events)**         * This new feature will replace SignalR.          * Locks real estate can be updated through **[PUT Locks](#operation/Locks_Update)** -endpoint        * Enum values and descriptions for **[Locks](#operation/Locks_GetLockById)** **PhysicalState** property     * **[GET Keys/{id}/TimeLimitTitles/CanAdd](#operation/Keys_CanAddTimeLimitTitle)** has new return value CanAddTimeLimit     * Two new read only properties for **[Keys](#operation/Keys_GetKey)**         * **ProgrammingState** of the key. This new field equivalent to 5 series Manager's Programming State -field.           * **IsProgrammed** has key ever been programmed.              * New endpoints      * **[GET Persons/{id}/NortecActivationCode](#operation/Persons_GetNortecCode)**       * Gets Nortec laundry code      * **[GET Webhooks/Subscriptions/{id}/Payloads](#operation/Webhooks_GetPayloadsForSubscription)**       * Gets payloads which have the given state. Returns most recent, maximum of 1000 payloads.     * **[GET Webhooks/Subscriptions/PendingPayloads](#operation/Webhooks_GetSubscriptionsWithPendingPayloads)**       * Gets webhook subscriptions which have sent payloads that aren't sent successfully (state = 3 or 4).    ## Version 6.9.1.0   * **Breaking changes**     * From this version on **S50 phone keys require Person_ID -link**. Inserting and updating phone key without person link will cause validation error and key will not be inserted or updated.  * New endpoints for key's security access and time profile management     * Key's security access management         * **[Can security access to be added to key](#operation/Keys_CanAddSecurityAccess)**         * **[Add security access to key](#operation/Keys_InsertSecurityAccess)**         * **[Can security access to be deleted from key](#operation/Keys_CanDeleteSecurityAccess)**         * **[Delete security access from key](#operation/Keys_DeleteSecurityAccess)**      * Key's time profile management         * **[Can time profile to added to key](#operation/Keys_CanAddTimeLimitTitle)**         * **[Add time profile to key](#operation/Keys_InsertTimeLimitTitle)**         * **[Modify key's time profile](#operation/Keys_UpdateTimeLimit)**         * **[Get information of key's time profile](#operation/Keys_GetTimeLimit)**         * **[Delete time profile from key](#operation/Keys_DeleteTimeLimit)**      * **[PUT Keys/{id}/SecurityAccesses](#operation/Keys_UpdateSecurityAccesses)** works as before  * New read-only property **TagKeyHex** for Keys     * RFID Tag presented as HEX. Empty if TagKey is absent.   ## Version 6.8.0.16  * **[Webhook (Beta)](#section/Webhook-(Beta))**     * Webhooks allows subscribing to events happening in iLOQ Manager and iLOQ Public Api  * New endpoint for **[re-registering phone keys](#operation/KeyPhones_SendPhoneRegistration)**   ## Version 6.5.0.1   * New endpoints **[KeyTag](#tag/KeyTags)**     * Ticketing support   # General advice and FAQ   In this section you can find few useful tips and FAQ for using iLOQ API.   ## API * Locking system has to be API enabled. See more in **[here](#section/Public-API/Usage)**. * To make changes to key's security accesses and order them via API, type of the security acceess that is being changed, has to be API access. Changes to Standard access require Manager and Token to order.   ## Can-methods  * iLOQ Public API provides several CanAdd, CanAddKey, CanRemoveKey, CanRemove, CanOrder, CanReturn -methods. These endpoints may provide usefull information why something cannot be done. It also prevents unsuccessfull POST and DELETE requests.   ## GUIDs and ID fields * General rule is that integrator defines new GUIDs for ID fields for POST requests. * Some POST endpoints may generate GUID or add 00000000-0000-0000-0000-000000000000 as GUID, but generate your own GUIDs also in these cases.  ## KeyTypeMask * KeyTypeMask describes type of the key. * Accepts the following combinations: S10 + iLoqKey (S10 key), S50 + PhoneKey (S50 phone key), S50 + iLoqKey (S50 fob key), 5 Series + iLoqKey (S5 key), 5 Series + Other than iLoq physical key (External RFID tag key).  ## Logging * We strongly advice to have sufficient logging on your side of integration. For security reasons iLOQ Public API does not log or store payloads of **successfull requests**. Errors are always logged in iLOQ Public API.  ## Rights * Locking system administrator grants user rights for API user when creating user. * Successfully logging to locking system with [POST SetLockgroup](#operation/Authentication_SetLockgroup) return RightsMask that contains user's rights as a bit mask. List of rights can be found [SetLockgroup](#operation/Authentication_SetLockgroup). * Contact your locking system administrator concerning insuffient user rights.  ## Terms   Here is some term differences between iLOQ 5 series Manager and iLOQ Public API  |Manager              |Public API | | --------------------|-------------------------| |Access rights        |SecurityAccesses         | |Blocklist            |Blacklist                | |Calendar             |CalendarDataTitles       | |Calendar control     |CalendarData             | |Code access groups   |SecurityRoles            | |Service code         |CustomerCode             | |Time profile         |TimeLimitTitles          |   # Contact For API support, contact api.support@iloq.com.  In problem situations provide **payloads**, possible **error responses** and **service code** to hasten support.  For non-API-related issues (like contract issues), contact other supports which can be found at https://www.iloq.com/en/sales/iloq-sales-support/  # Webhook (Beta)  Webhooks allow you to build or set up integrations in a loosely coupled manner. Webhooks are created by subscribing to certain events happening in iLOQ. When one of those events is triggered, we will send a `HTTP POST` payload to the URL that has been provided by you.  Once the subscription is created and active, payload will be sent each time the subscribed event occurs.  Up to **3** subscriptions can be created for each event per locking system.  <h3>Subscription</h3>  When creating a subscription, you define which event you're interested in and `http(s)://` endpoint where the payload will be sent. Following information needs to be provided: 1. Endpoint URL that accepts `HTTP POST` requests 2. Starting date and time; when will this subscription start sending payloads 3. Ending date and time; when will this subscription stop sending payloads. Maximum is one year ahead. 4. Event; what occurring event will send the payload 5. Subscription Id; guid generated by you 6. *Custom header (Optional)*; free text that will be sent as part of the payload header 7. *JSON path filter (Optional)*; filter out data you are not interested in  <h4>JSON path filter</h4>  `JSON path filter` -property allows you to filter out events by using [JSON path](https://tools.ietf.org/id/draft-goessner-dispatch-jsonpath-00.html). For example, by giving the following value `$[?($.KeyTypeMask == 9 || $.KeyTypeMask == 4)]`, you receive only payloads that have `KeyTypeMask` with value `4 or 9`, the rest will be ignored. See _Events and Payloads_ for property names that can be used to filter out the webhooks.  <h3>Event</h3>  Each event corresponds to a certain action that can happen within your iLOQ environment. For example, if you subscribe to the `key_added` event, you will receive detailed payload every time an key has been added via iLOQ manager or iLOQ Public api. If you are interested in only certain keys, you can use Json path filter to filter the events.  For a complete list of available webhook events and their payloads, see _Events and Payloads_  <h3>Preparing to receive webhooks</h3>  Provide a public RESTFUL endpoint that accepts the `HTTP POST` requests. If you use `HTTPS`, make sure the certification is correctly setup and matches your domain. Design your endpoint in asynchronous manner. For ex. provide response with a http status code `2xx` instantly and do long-running tasks in the background. Format of the response is irrelevant, but it will be persisted for troubleshooting purposes and the content size is limited to `1MB`  <h3>Error handling & limitations</h3>  If the payload sent by iLOQ does not succesfully complete, iLOQ will try to resend the payloads in a following manner:  |Failed attempts|Delay| |--|--| |1|5 minutes| |2|15 minutes| |3|1 hour| |4|6 hours| |5|12 hours| |6|24 hours|  This totals 7 requests, after that has been reached, this specific event is marked as obsolete and iLOQ stops sending the payload.  For troubleshooting purposes, each unique webhook (and related response given by your endpoint) is persisted for `30 days` and permanently removed after that threshold is reached  <h3>Errors in response</h3>  Webhook sender will check the status code endpoint gives in the response. If the response contains status code that's something else than 2xx, this specific event is marked as failed and iLOQ will try resending the payload later.  <h4>Timeout</h4>  Webhook sender will timeout after **5** seconds if no response is given. Prepare your receiving endpoint in a asynchronous manner so that you can provide the response as soon as possible. If timeout occurs, this specific event is marked as failed and iLOQ will try resending the payload later.  <h4>SSL verification error</h4>  If HTTPS-address is used and SSL verification fails, this specific event is marked as failed and iLOQ will try resending the payload later.  <h4>Host unreachable</h4>  If host is unreachable, this specific event is marked as failed and iLOQ will try resending the payload later.  <h4> Payload common properties </h4>  Each webhook sent by iLOQ has content-type of `application/json; charset=utf-8` and contains following common properties:  <h4>Headers</h4>  |Key|Type|Description|Example |--|--|--|--| |Counter|number|Incremental counter that shows how many unique payloads has been sent to the endpoint provided in the subscription.<br><br>**Important:** Resent requests won't increase the count|2342| |Event-Name|string|Name of the event|key_added| |Subscription-Id|string|Subscription Id that was provided when creating the subscription|90B3B527-3667-4CF8-9930-5D744E5EA877| |Webhook-Signature|string|[Webhook Signature](https://dev.azure.com/SebittiiLOQ/iLOQWebhook/_wiki/wikis/iLOQWebhook-dokumentaatio/41/Webhook-Signature) related to this payload|3133e11d8b3087cf5c2b33c2c14ce4701f5b31a4746f9245681be32449958930| |Custom-Header|string<br>*optional*|Free text given for the subscription. Is delivered as Base64 encoded string|dGVzdA==  <h4>Payload body</h4>  |Key|Type|Description|Example| |--|--|--|--| |Data|object|Event related data provided<br><br>See *Events* for detailed descriptions for each event|{\"Description\": \"string\",\"ExpireDate\": \"2021-04-20T10:42:40.803Z\",\"FNKey_ID\": \"3fa85f64-5717-4562-b3fc-2c963f66afa6\", \"InfoText\": \"string\", \"KeyTypeMask\": 0, \"Person_ID\": \"3fa85f64-5717-4562-b3fc-2c963f66afa6\", \"RealEstate_ID\": \"3fa85f64-5717-4562-b3fc-2c963f66afa6\", \"ROM_ID\": \"string\", \"Stamp\": \"string\", \"StampSource\": 0, \"State\": 0, \"TagKey\": \"string\", \"TagKeySource\": 0, \"VersionCode\": \"string\"} |CreationTimeUtc|string|UTC timestamp when the payload was sent|2021-04-29T09:08:31.6653347Z  ## Events Each event has unique Data provided within the payload's `BODY`  ### key_added  Key added event occurs, when new key has been added via iLOQ Manager or iLOQ Public api  |Key|Type|Description| |--|--|--| |Description|string|Description text| |ExpireDate|string?|Expiration date. Null if the key doesn't expire| |FNKey_ID|string(Guid)|Key Id| |InfoText|string|Additional info text| |KeyTypeMask|number|Key's types in bitmask| |Person_ID|string?(Guid)|Person to whom the key is linked to. Null if the key isn't linked to anyone| |RealEstate_ID|string(Guid)|Id of the real estate where this key belongs to| |ROM_ID|string|ROM ID| |Stamp|string|Number consisting of 4 digits written to the physical key| |StampSource|number|The source of the key labeling (Stamp)| |State|number|Current state| |TagKey|string|RFID Tag. Empty string if not given| |TagKeySource|int|The source of the key's tagkey enumeration| |VersionCode|string|Version information|  Key Added payload example (prettified)  ``` {   \"Data\": {     \"Description\": \"string\",     \"ExpireDate\": \"2021-04-20T10:42:40.803Z\",     \"FNKey_ID\": \"3fa85f64-5717-4562-b3fc-2c963f66afa6\",     \"InfoText\": \"string\",     \"KeyTypeMask\": 0,     \"Person_ID\": \"3fa85f64-5717-4562-b3fc-2c963f66afa6\",     \"RealEstate_ID\": \"3fa85f64-5717-4562-b3fc-2c963f66afa6\",     \"ROM_ID\": \"string\",     \"Stamp\": \"string\",     \"StampSource\": 0,     \"State\": 0,     \"TagKey\": \"string\",     \"TagKeySource\": 0,     \"VersionCode\": \"string\"   },   \"CreationTimeUtc\": \"2021-04-27T14:54:06.747\" } ```  Full Request example ``` POST http://10.0.1.6/iLOQWebhookReceiver/api/testing/key-added HTTP/1.1 Host: 10.0.1.6 Webhook-Signature: 8e67b39b6507f0ac9b559ba9c57a1efb12b40e632eabd99c316213fdaf4261f1 Event-Name: key_added Custom-Header: VGVzdCBoZWFkZXI= Subscription-Id: 449226d9-bb2f-41f2-be90-32ec2b9b00c4 Counter: 5304 Content-Type: application/json; charset=utf-8 Content-Length: 433  {\"Data\":{\"Description\":\"string\",\"ExpireDate\":\"2021-04-20T10:42:40.803Z\",\"FNKey_ID\":\"3fa85f64-5717-4562-b3fc-2c963f66afa6\",\"InfoText\":\"string\",\"KeyTypeMask\":0,\"Person_ID\":\"3fa85f64-5717-4562-b3fc-2c963f66afa6\",\"RealEstate_ID\":\"3fa85f64-5717-4562-b3fc-2c963f66afa6\",\"ROM_ID\":\"string\",\"Stamp\":\"string\",\"StampSource\":0,\"State\":0,\"TagKey\":\"string\",\"TagKeySource\":0,\"VersionCode\":\"string\"},\"CreationTimeUtc\":\"2021-04-29T09:08:31.6653347Z\"} ```  ### key_blocklisted  Key blocklisted event occurs, when key has been blocklisted via iLOQ Manager or iLOQ Public api  |Key|Type|Description| |--|--|--| |Description|string|Description text| |ExpireDate|string?|Expiration date. Null if the key doesn't expire| |FNKey_ID|string(Guid)|Key Id| |InfoText|string|Additional info text| |KeyTypeMask|number|Key's types in bitmask| |Person_ID|string?(Guid)|Person to whom the key is linked to. Null if the key isn't linked to anyone| |RealEstate_ID|string(Guid)|Id of the real estate where this key belongs to| |ROM_ID|string|ROM ID| |Stamp|string|Number consisting of 4 digits written to the physical key| |StampSource|number|The source of the key labeling (Stamp)| |State|number|Current state| |TagKey|string|RFID Tag. Empty string if not given| |TagKeySource|int|The source of the key's tagkey enumeration| |VersionCode|string|Version information|  Key Blocklisted payload example (prettified) ``` {   \"Data\": {     \"Description\": \"string\",     \"ExpireDate\": \"2021-04-20T10:42:40.803Z\",     \"FNKey_ID\": \"3fa85f64-5717-4562-b3fc-2c963f66afa6\",     \"InfoText\": \"string\",     \"KeyTypeMask\": 0,     \"Person_ID\": \"3fa85f64-5717-4562-b3fc-2c963f66afa6\",     \"RealEstate_ID\": \"3fa85f64-5717-4562-b3fc-2c963f66afa6\",     \"ROM_ID\": \"string\",     \"Stamp\": \"string\",     \"StampSource\": 0,     \"State\": 0,     \"TagKey\": \"string\",     \"TagKeySource\": 0,     \"VersionCode\": \"string\"   },   \"CreationTimeUtc\": \"2021-04-27T14:54:06.747Z\" } ``` Full Request example ``` POST http://10.0.1.6/iLOQWebhookReceiver/api/testing/key-added HTTP/1.1 Host: 10.0.1.6 Webhook-Signature: 8e67b39b6507f0ac9b559ba9c57a1efb12b40e632eabd99c316213fdaf4261f1 Event-Name: key_blocklisted Custom-Header: VGVzdCBoZWFkZXI= Subscription-Id: 3fa85f64-5717-4562-b3fc-2c963f66afa6 Counter: 5304 Content-Type: application/json; charset=utf-8 Content-Length: 433  {\"Data\":{\"Description\":\"string\",\"ExpireDate\":\"2021-04-20T10:42:40.803Z\",\"FNKey_ID\":\"3fa85f64-5717-4562-b3fc-2c963f66afa6\",\"InfoText\":\"string\",\"KeyTypeMask\":0,\"Person_ID\":\"3fa85f64-5717-4562-b3fc-2c963f66afa6\",\"RealEstate_ID\":\"3fa85f64-5717-4562-b3fc-2c963f66afa6\",\"ROM_ID\":\"string\",\"Stamp\":\"string\",\"StampSource\":0,\"State\":0,\"TagKey\":\"string\",\"TagKeySource\":0,\"VersionCode\":\"string\"},\"CreationTimeUtc\":\"2021-04-29T09:08:31.6653347Z\"} ```  ### device_log_arrived Device log arrived event occurs, when lock, key or network module sends audit trails or other device logs to server  |Key|Type|Description| |--|--|--| |DeviceLogTypeMask|int|Lock log types as bit mask values. For example 1028 would be successful S10 key access. 12 would be successful phone access etc.| |FLock_ID|string(Guid)?|Id of the lock. Null if the event isn't related to lock| |FNKey_ID|string(Guid)?|Id of the key. Null if the event isn't related to key| |GoingDateUtc|string?|Date and time of log access. Null if the event isn't related to key or lock access| |KeyTypeMask|number?|Key's types in bitmask. Null if the event isn't related to key| |LanguageCode|string?|Language code for person linked to key. Null if the event isn't related to key or this information is not available| |LockSerialNumber|int?|Serial number for the lock. Null if the event isn't related to lock| |Person_ID|string?|Id of the person to whom the key is linked to. Null if the key isn't linked to anyone or the event isn't related to key| |PersonFullName|string)|Full name of the person to whom the key is linked to. Null if the key isn't linked to anyone or the event isn't related to key| |PhoneEmail|string)|Email linked to the phone key. Null if the event isn't related to phone key| |PhoneNo|string)|Phone number linked to the phone key. Null if the event isn't related to phone key| |RealEstate_ID|string?|Id of the real estate where lock belongs to. Null if the event isn't related to lock|  Device Log Arrived payload example (prettified) ``` {   \"Data\": {     \"DeviceLogTypeMask\": 12,     \"FLock_ID\": \"3589CBEB-C801-41C9-BB06-B7A51C1F346B\",     \"fnKey_ID\": \"FD051B34-5DDC-485A-915A-205016EA74D6\",     \"GoingDateUtc\": \"2022-05-09T14:54:06.747Z\",     \"KeyTypeMask\": 4,     \"Person_ID\": \"36FCDD5C-D306-43EC-845D-DB424568F38B\",     \"RealEstate_ID\": \"0565B189-9474-4E06-94F6-DAD33F2863F5\",     \"LanguageCode\": \"FIN\",     \"LockSerialNumber\": 123456,     \"PersonFullName\": \"Foo Bar\",     \"PhoneEmail\": \"foo@domain.com\",     \"PhoneNo\": \"555-12345678\"   },   \"CreationTimeUtc\": \"2022-05-11T14:54:06.747Z\" } ``` Full Request example ``` POST http://10.0.1.6/iLOQWebhookReceiver/api/testing/device-log-arrived HTTP/1.1 Host: 10.0.1.6 Webhook-Signature: 8e67b39b6507f0ac9b559ba9c57a1efb12b40e632eabd99c316213fdaf4261f1 Event-Name: device_log_arrived Custom-Header: VGVzdCBoZWFkZXI= Subscription-Id: 3fa85f64-5717-4562-b3fc-2c963f66afa6 Counter: 1204 Content-Type: application/json; charset=utf-8 Content-Length: 433  {\"Data\":{\"DeviceLogTypeMask\":12,\"FLock_ID\":\"3589CBEB-C801-41C9-BB06-B7A51C1F346B\",\"fnKey_ID\":\"FD051B34-5DDC-485A-915A-205016EA74D6\",\"GoingDateUtc\":\"2022-05-09T14:54:06.747Z\",\"KeyTypeMask\":4,\"Person_ID\":\"36FCDD5C-D306-43EC-845D-DB424568F38B\",\"RealEstate_ID\":\"0565B189-9474-4E06-94F6-DAD33F2863F5\",\"LanguageCode\":\"FIN\",\"LockSerialNumber\":123456,\"PersonFullName\":\"Foo Bar\",\"PhoneEmail\":\"foo@domain.com\",\"PhoneNo\":\"555-12345678\"},\"CreationTimeUtc\":\"2022-05-11T14:54:06.747Z\"} ```  ## Webhook signature  Webhook service will create unique signature for each sent webhook.   By recreating and comparing this hex digest to the one sent within the headers, payload receiver can make sure that the payload has remained intact and is sent from a trusty source.  Signature is within the HEADER `Webhook-Signature`  To recreate this hex digest, you will need following info: * `SignKey` linked to the subscription * `BODY` of the payload  `Webhook-Signature` is the HMAC hex digest of the request body, and is generated using the SHA-256 hash function and the `SignKey` as the HMAC key.  <h3>Example</h3>  Body of the payload:  ```{\"Data\":{\"Description\":\"kuvaus\",\"ExpireDate\":\"2021-04-20T10:42:40.803Z\",\"FNKey_ID\":\"3fa85f64-5717-4562-b3fc-2c963f66afa6\",\"InfoText\":\"infoa\",\"KeyTypeMask\":0,\"Person_ID\":\"3fa85f64-5717-4562-b3fc-2c963f66afa6\",\"RealEstate_ID\":\"3fa85f64-5717-4562-b3fc-2c963f66afa6\",\"ROM_ID\":\"string\",\"Stamp\":\"string\",\"StampSource\":0,\"State\":0,\"TagKey\":\"string\",\"TagKeySource\":0,\"VersionCode\":\"string\"},\"CreationTimeUtc\":\"2021-01-05T12:15:30Z\"}```  SignKey:  `EFE3FD29-0B3E-405F-98EE-0CC5385DF5D5`  With the above data, following `Webhook-Signature` is generated:  `0468a4741fc1445f9b70805456016c88ad5b61544dd8c38502be546f3e05b4e8`  <h4>Code example (C#)</h4>  ``` public static string ComputeWebhookSignature(string signKey, string body) {     var bytes = Encoding.UTF8.GetBytes(signKey);     using (var hasher = new HMACSHA256(bytes))     {         var data = Encoding.UTF8.GetBytes(body);         return BitConverter.ToString(hasher.ComputeHash(data)).ToLower().Replace(\"-\", \"\");     } } ```  <h3>Additional security</h3>  Each payload body will contain property `CreationTimeUtc`. This timestamp is generated just before sending the request. This will allow the receiver to secure themselves from *Replay*-attacks, for ex. by validating that the `CreationTimeUtc` is below some threshold.
 *
 * The version of the OpenAPI document: v2
 * Generated by: https://openapi-generator.tech
 * Generator version: 7.10.0
 */

/**
 * NOTE: This class is auto generated by OpenAPI Generator (https://openapi-generator.tech).
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace OpenAPI\Client\Model;

use \ArrayAccess;
use \OpenAPI\Client\ObjectSerializer;

/**
 * LockGroup Class Doc Comment
 *
 * @category Class
 * @description Locking system
 * @package  OpenAPI\Client
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 * @implements \ArrayAccess<string, mixed>
 */
class LockGroup implements ModelInterface, ArrayAccess, \JsonSerializable
{
    public const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $openAPIModelName = 'LockGroup';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $openAPITypes = [
        'adapter_version' => 'int',
        'address' => 'string',
        'classification' => 'string',
        'contact_person' => 'string',
        'country_code' => 'string',
        'customer_id' => 'string',
        'description' => 'string',
        'expire_date_utc' => '\DateTime',
        'front_image' => 'string',
        'info_text' => 'string',
        'lock_group_id' => 'string',
        'name' => 'string',
        'option_mask' => 'int',
        'programming_admin' => 'string',
        'state' => 'int',
        'time_zone_standard_name' => 'string'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      * @phpstan-var array<string, string|null>
      * @psalm-var array<string, string|null>
      */
    protected static $openAPIFormats = [
        'adapter_version' => null,
        'address' => null,
        'classification' => null,
        'contact_person' => null,
        'country_code' => null,
        'customer_id' => 'guid',
        'description' => null,
        'expire_date_utc' => 'date-time',
        'front_image' => 'byte',
        'info_text' => null,
        'lock_group_id' => 'guid',
        'name' => null,
        'option_mask' => 'int32',
        'programming_admin' => null,
        'state' => null,
        'time_zone_standard_name' => null
    ];

    /**
      * Array of nullable properties. Used for (de)serialization
      *
      * @var boolean[]
      */
    protected static array $openAPINullables = [
        'adapter_version' => false,
        'address' => true,
        'classification' => true,
        'contact_person' => true,
        'country_code' => true,
        'customer_id' => false,
        'description' => true,
        'expire_date_utc' => true,
        'front_image' => true,
        'info_text' => true,
        'lock_group_id' => false,
        'name' => true,
        'option_mask' => false,
        'programming_admin' => true,
        'state' => false,
        'time_zone_standard_name' => true
    ];

    /**
      * If a nullable field gets set to null, insert it here
      *
      * @var boolean[]
      */
    protected array $openAPINullablesSetToNull = [];

    /**
     * Array of property to type mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function openAPITypes()
    {
        return self::$openAPITypes;
    }

    /**
     * Array of property to format mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function openAPIFormats()
    {
        return self::$openAPIFormats;
    }

    /**
     * Array of nullable properties
     *
     * @return array
     */
    protected static function openAPINullables(): array
    {
        return self::$openAPINullables;
    }

    /**
     * Array of nullable field names deliberately set to null
     *
     * @return boolean[]
     */
    private function getOpenAPINullablesSetToNull(): array
    {
        return $this->openAPINullablesSetToNull;
    }

    /**
     * Setter - Array of nullable field names deliberately set to null
     *
     * @param boolean[] $openAPINullablesSetToNull
     */
    private function setOpenAPINullablesSetToNull(array $openAPINullablesSetToNull): void
    {
        $this->openAPINullablesSetToNull = $openAPINullablesSetToNull;
    }

    /**
     * Checks if a property is nullable
     *
     * @param string $property
     * @return bool
     */
    public static function isNullable(string $property): bool
    {
        return self::openAPINullables()[$property] ?? false;
    }

    /**
     * Checks if a nullable property is set to null.
     *
     * @param string $property
     * @return bool
     */
    public function isNullableSetToNull(string $property): bool
    {
        return in_array($property, $this->getOpenAPINullablesSetToNull(), true);
    }

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @var string[]
     */
    protected static $attributeMap = [
        'adapter_version' => 'AdapterVersion',
        'address' => 'Address',
        'classification' => 'Classification',
        'contact_person' => 'ContactPerson',
        'country_code' => 'CountryCode',
        'customer_id' => 'Customer_ID',
        'description' => 'Description',
        'expire_date_utc' => 'ExpireDateUTC',
        'front_image' => 'FrontImage',
        'info_text' => 'InfoText',
        'lock_group_id' => 'LockGroup_ID',
        'name' => 'Name',
        'option_mask' => 'OptionMask',
        'programming_admin' => 'ProgrammingAdmin',
        'state' => 'State',
        'time_zone_standard_name' => 'TimeZoneStandardName'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'adapter_version' => 'setAdapterVersion',
        'address' => 'setAddress',
        'classification' => 'setClassification',
        'contact_person' => 'setContactPerson',
        'country_code' => 'setCountryCode',
        'customer_id' => 'setCustomerId',
        'description' => 'setDescription',
        'expire_date_utc' => 'setExpireDateUtc',
        'front_image' => 'setFrontImage',
        'info_text' => 'setInfoText',
        'lock_group_id' => 'setLockGroupId',
        'name' => 'setName',
        'option_mask' => 'setOptionMask',
        'programming_admin' => 'setProgrammingAdmin',
        'state' => 'setState',
        'time_zone_standard_name' => 'setTimeZoneStandardName'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'adapter_version' => 'getAdapterVersion',
        'address' => 'getAddress',
        'classification' => 'getClassification',
        'contact_person' => 'getContactPerson',
        'country_code' => 'getCountryCode',
        'customer_id' => 'getCustomerId',
        'description' => 'getDescription',
        'expire_date_utc' => 'getExpireDateUtc',
        'front_image' => 'getFrontImage',
        'info_text' => 'getInfoText',
        'lock_group_id' => 'getLockGroupId',
        'name' => 'getName',
        'option_mask' => 'getOptionMask',
        'programming_admin' => 'getProgrammingAdmin',
        'state' => 'getState',
        'time_zone_standard_name' => 'getTimeZoneStandardName'
    ];

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @return array
     */
    public static function attributeMap()
    {
        return self::$attributeMap;
    }

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @return array
     */
    public static function setters()
    {
        return self::$setters;
    }

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @return array
     */
    public static function getters()
    {
        return self::$getters;
    }

    /**
     * The original name of the model.
     *
     * @return string
     */
    public function getModelName()
    {
        return self::$openAPIModelName;
    }


    /**
     * Associative array for storing property values
     *
     * @var mixed[]
     */
    protected $container = [];

    /**
     * Constructor
     *
     * @param mixed[] $data Associated array of property values
     *                      initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->setIfExists('adapter_version', $data ?? [], null);
        $this->setIfExists('address', $data ?? [], null);
        $this->setIfExists('classification', $data ?? [], null);
        $this->setIfExists('contact_person', $data ?? [], null);
        $this->setIfExists('country_code', $data ?? [], null);
        $this->setIfExists('customer_id', $data ?? [], null);
        $this->setIfExists('description', $data ?? [], null);
        $this->setIfExists('expire_date_utc', $data ?? [], null);
        $this->setIfExists('front_image', $data ?? [], null);
        $this->setIfExists('info_text', $data ?? [], null);
        $this->setIfExists('lock_group_id', $data ?? [], null);
        $this->setIfExists('name', $data ?? [], null);
        $this->setIfExists('option_mask', $data ?? [], null);
        $this->setIfExists('programming_admin', $data ?? [], null);
        $this->setIfExists('state', $data ?? [], null);
        $this->setIfExists('time_zone_standard_name', $data ?? [], null);
    }

    /**
    * Sets $this->container[$variableName] to the given data or to the given default Value; if $variableName
    * is nullable and its value is set to null in the $fields array, then mark it as "set to null" in the
    * $this->openAPINullablesSetToNull array
    *
    * @param string $variableName
    * @param array  $fields
    * @param mixed  $defaultValue
    */
    private function setIfExists(string $variableName, array $fields, $defaultValue): void
    {
        if (self::isNullable($variableName) && array_key_exists($variableName, $fields) && is_null($fields[$variableName])) {
            $this->openAPINullablesSetToNull[] = $variableName;
        }

        $this->container[$variableName] = $fields[$variableName] ?? $defaultValue;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        return $invalidProperties;
    }

    /**
     * Validate all the properties in the model
     * return true if all passed
     *
     * @return bool True if all properties are valid
     */
    public function valid()
    {
        return count($this->listInvalidProperties()) === 0;
    }


    /**
     * Gets adapter_version
     *
     * @return int|null
     */
    public function getAdapterVersion()
    {
        return $this->container['adapter_version'];
    }

    /**
     * Sets adapter_version
     *
     * @param int|null $adapter_version Adapter version which user has set in the locking system settings.    0 = Adapter doesn't exist or it isn't recognized    1 = Adapter which doesn't have flash memory.    2 = Adapter which supports flash memory (if installed)    4 = Adapter which supports the making of laundry room keys (programming packet may contain key's name)
     *
     * @return self
     */
    public function setAdapterVersion($adapter_version)
    {
        if (is_null($adapter_version)) {
            throw new \InvalidArgumentException('non-nullable adapter_version cannot be null');
        }
        $this->container['adapter_version'] = $adapter_version;

        return $this;
    }

    /**
     * Gets address
     *
     * @return string|null
     */
    public function getAddress()
    {
        return $this->container['address'];
    }

    /**
     * Sets address
     *
     * @param string|null $address Street address/city where the locking system is in use
     *
     * @return self
     */
    public function setAddress($address)
    {
        if (is_null($address)) {
            array_push($this->openAPINullablesSetToNull, 'address');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('address', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['address'] = $address;

        return $this;
    }

    /**
     * Gets classification
     *
     * @return string|null
     */
    public function getClassification()
    {
        return $this->container['classification'];
    }

    /**
     * Sets classification
     *
     * @param string|null $classification Classification
     *
     * @return self
     */
    public function setClassification($classification)
    {
        if (is_null($classification)) {
            array_push($this->openAPINullablesSetToNull, 'classification');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('classification', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['classification'] = $classification;

        return $this;
    }

    /**
     * Gets contact_person
     *
     * @return string|null
     */
    public function getContactPerson()
    {
        return $this->container['contact_person'];
    }

    /**
     * Sets contact_person
     *
     * @param string|null $contact_person Contact person's name
     *
     * @return self
     */
    public function setContactPerson($contact_person)
    {
        if (is_null($contact_person)) {
            array_push($this->openAPINullablesSetToNull, 'contact_person');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('contact_person', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['contact_person'] = $contact_person;

        return $this;
    }

    /**
     * Gets country_code
     *
     * @return string|null
     */
    public function getCountryCode()
    {
        return $this->container['country_code'];
    }

    /**
     * Sets country_code
     *
     * @param string|null $country_code Locking system's country code. For example \"FIN\" for Finnish.
     *
     * @return self
     */
    public function setCountryCode($country_code)
    {
        if (is_null($country_code)) {
            array_push($this->openAPINullablesSetToNull, 'country_code');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('country_code', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['country_code'] = $country_code;

        return $this;
    }

    /**
     * Gets customer_id
     *
     * @return string|null
     */
    public function getCustomerId()
    {
        return $this->container['customer_id'];
    }

    /**
     * Sets customer_id
     *
     * @param string|null $customer_id Customer ID who owns the lockgroup
     *
     * @return self
     */
    public function setCustomerId($customer_id)
    {
        if (is_null($customer_id)) {
            throw new \InvalidArgumentException('non-nullable customer_id cannot be null');
        }
        $this->container['customer_id'] = $customer_id;

        return $this;
    }

    /**
     * Gets description
     *
     * @return string|null
     */
    public function getDescription()
    {
        return $this->container['description'];
    }

    /**
     * Sets description
     *
     * @param string|null $description Description
     *
     * @return self
     */
    public function setDescription($description)
    {
        if (is_null($description)) {
            array_push($this->openAPINullablesSetToNull, 'description');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('description', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['description'] = $description;

        return $this;
    }

    /**
     * Gets expire_date_utc
     *
     * @return \DateTime|null
     */
    public function getExpireDateUtc()
    {
        return $this->container['expire_date_utc'];
    }

    /**
     * Sets expire_date_utc
     *
     * @param \DateTime|null $expire_date_utc Date when locking system expires. Null if doesn't expire.
     *
     * @return self
     */
    public function setExpireDateUtc($expire_date_utc)
    {
        if (is_null($expire_date_utc)) {
            array_push($this->openAPINullablesSetToNull, 'expire_date_utc');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('expire_date_utc', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['expire_date_utc'] = $expire_date_utc;

        return $this;
    }

    /**
     * Gets front_image
     *
     * @return string|null
     */
    public function getFrontImage()
    {
        return $this->container['front_image'];
    }

    /**
     * Sets front_image
     *
     * @param string|null $front_image User set image which is displayed on the start page of iLOQ Manager. Null if not set.
     *
     * @return self
     */
    public function setFrontImage($front_image)
    {
        if (is_null($front_image)) {
            array_push($this->openAPINullablesSetToNull, 'front_image');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('front_image', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['front_image'] = $front_image;

        return $this;
    }

    /**
     * Gets info_text
     *
     * @return string|null
     */
    public function getInfoText()
    {
        return $this->container['info_text'];
    }

    /**
     * Sets info_text
     *
     * @param string|null $info_text General user written info text.
     *
     * @return self
     */
    public function setInfoText($info_text)
    {
        if (is_null($info_text)) {
            array_push($this->openAPINullablesSetToNull, 'info_text');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('info_text', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['info_text'] = $info_text;

        return $this;
    }

    /**
     * Gets lock_group_id
     *
     * @return string|null
     */
    public function getLockGroupId()
    {
        return $this->container['lock_group_id'];
    }

    /**
     * Sets lock_group_id
     *
     * @param string|null $lock_group_id ID
     *
     * @return self
     */
    public function setLockGroupId($lock_group_id)
    {
        if (is_null($lock_group_id)) {
            throw new \InvalidArgumentException('non-nullable lock_group_id cannot be null');
        }
        $this->container['lock_group_id'] = $lock_group_id;

        return $this;
    }

    /**
     * Gets name
     *
     * @return string|null
     */
    public function getName()
    {
        return $this->container['name'];
    }

    /**
     * Sets name
     *
     * @param string|null $name Name of the locking system
     *
     * @return self
     */
    public function setName($name)
    {
        if (is_null($name)) {
            array_push($this->openAPINullablesSetToNull, 'name');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('name', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['name'] = $name;

        return $this;
    }

    /**
     * Gets option_mask
     *
     * @return int|null
     */
    public function getOptionMask()
    {
        return $this->container['option_mask'];
    }

    /**
     * Sets option_mask
     *
     * @param int|null $option_mask Option mask of the settings in use in the locking system.    0 = None    1 = Key's, which has been handed over, person can be changed without returning the key.    2 = Zones are in use.    4 = Real estates are in use    8 = Is Tag field visible for key    16 = Can keys' tags be edited    32 = Code groups are in use    64 = Lock's time limits are split into key's time limits    128 = Key's PIN code in use    256 = Is locking system in 24 bit mode    512 = Addition for CanUseSpace value. Are zones in use on keys and persons    1024 = Can set key's packet valid from date    2048 = Is Public API in use    4096 = Is S50 locking system in use    8192 = Is S10 locking system in use    16384 = Can locking system use API access rights    32768 = Are external RFID tags in use    65536 = Is 5 Series locking system in use    131072 = Is zone specific black list in use    262144 = Is iLOQ HOME in use    524288 = Is 23 time limit slots for keys and locks in use instead of default 10.              Locks with firmware greater than 138 support 23 time limit slots.              NOT IN USE.    1048576 = Locking system has K5S.1-6 capability on meaning it supports keys with software version 1-199.              No restrictions to lock software versions.    2097152 = Locking system has K5S.7-9 capability on meaning it supports keys with software version 200-99999.              C5 Locks software version must be >= 149              D5 Locks software version must be >= 148              D5i Locks software version must be >= 141              C5R software version must be >= 300              D5R software version must be >= 300    4194304 = For development time use. Enables not finished features in 5 Series Manager.    8388608 = Whether S50 lock closing reminder is in use.              8 388 608    16777216 = Whether multiple time zones are in use in the locking system.              16 777 216    33554432 = Whether key updates are blocked through gateway              33 554 432    67108864 = Whether gateway key fob log read task is enabled              67 108 864
     *
     * @return self
     */
    public function setOptionMask($option_mask)
    {
        if (is_null($option_mask)) {
            throw new \InvalidArgumentException('non-nullable option_mask cannot be null');
        }
        $this->container['option_mask'] = $option_mask;

        return $this;
    }

    /**
     * Gets programming_admin
     *
     * @return string|null
     */
    public function getProgrammingAdmin()
    {
        return $this->container['programming_admin'];
    }

    /**
     * Sets programming_admin
     *
     * @param string|null $programming_admin Name of the person who is responsible for programming tasks
     *
     * @return self
     */
    public function setProgrammingAdmin($programming_admin)
    {
        if (is_null($programming_admin)) {
            array_push($this->openAPINullablesSetToNull, 'programming_admin');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('programming_admin', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['programming_admin'] = $programming_admin;

        return $this;
    }

    /**
     * Gets state
     *
     * @return int|null
     */
    public function getState()
    {
        return $this->container['state'];
    }

    /**
     * Sets state
     *
     * @param int|null $state Is locking system in use or not    0 = Locking system is active (in use)    1 = Locking system is not active (not in use)
     *
     * @return self
     */
    public function setState($state)
    {
        if (is_null($state)) {
            throw new \InvalidArgumentException('non-nullable state cannot be null');
        }
        $this->container['state'] = $state;

        return $this;
    }

    /**
     * Gets time_zone_standard_name
     *
     * @return string|null
     */
    public function getTimeZoneStandardName()
    {
        return $this->container['time_zone_standard_name'];
    }

    /**
     * Sets time_zone_standard_name
     *
     * @param string|null $time_zone_standard_name Name of the time zone the locking system uses as default for new administrative zones. For example 'FLE Standard Time'.
     *
     * @return self
     */
    public function setTimeZoneStandardName($time_zone_standard_name)
    {
        if (is_null($time_zone_standard_name)) {
            array_push($this->openAPINullablesSetToNull, 'time_zone_standard_name');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('time_zone_standard_name', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['time_zone_standard_name'] = $time_zone_standard_name;

        return $this;
    }
    /**
     * Returns true if offset exists. False otherwise.
     *
     * @param integer $offset Offset
     *
     * @return boolean
     */
    public function offsetExists($offset): bool
    {
        return isset($this->container[$offset]);
    }

    /**
     * Gets offset.
     *
     * @param integer $offset Offset
     *
     * @return mixed|null
     */
    #[\ReturnTypeWillChange]
    public function offsetGet($offset)
    {
        return $this->container[$offset] ?? null;
    }

    /**
     * Sets value based on offset.
     *
     * @param int|null $offset Offset
     * @param mixed    $value  Value to be set
     *
     * @return void
     */
    public function offsetSet($offset, $value): void
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    /**
     * Unsets offset.
     *
     * @param integer $offset Offset
     *
     * @return void
     */
    public function offsetUnset($offset): void
    {
        unset($this->container[$offset]);
    }

    /**
     * Serializes the object to a value that can be serialized natively by json_encode().
     * @link https://www.php.net/manual/en/jsonserializable.jsonserialize.php
     *
     * @return mixed Returns data which can be serialized by json_encode(), which is a value
     * of any type other than a resource.
     */
    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
       return ObjectSerializer::sanitizeForSerialization($this);
    }

    /**
     * Gets the string presentation of the object
     *
     * @return string
     */
    public function __toString()
    {
        return json_encode(
            ObjectSerializer::sanitizeForSerialization($this),
            JSON_PRETTY_PRINT
        );
    }

    /**
     * Gets a header-safe presentation of the object
     *
     * @return string
     */
    public function toHeaderValue()
    {
        return json_encode(ObjectSerializer::sanitizeForSerialization($this));
    }
}


