
@extends('wrapper')
 
@section('content')
    <div class="DisplayText">
        This program parses tide data from a text file, and then provides the user with a list of dates, which the user can then tap to view all the tide info for each date. 
        This lab introduced fragments; differing layouts based on screen size and pixel density. 
        If the user's screen is large enough, e.g. most tablets, the program will show the list and the single date details side by side. 
        If the user's screen is small, e.g. a cellphone, the program will switch between the list and the tide details.
        <br><br>
        While I was studying at LCC I had the opportunity to take a mobile development class. 
        We used Xamarin Studio for windows(<i>shudders in horror</i>) and C#.
        This lab was one of the most gratifying experiences I've had programming. 
        I had many issues while working on this, several of which stumped everyone I asked, including the instructor. 
        I spent almost 2 weeks on this program, the most time I had spent on a program up to that point, and at the end thoroughly understood what was going on and where all my original issues were coming from.
        <br><br>
        
    </div>

    <pre class='pre-code'>
//this class is assigned in the layout file
<b>public class FragmentClass : ListFragment</b>
{
    List<TideItem> TideItems;
    List<TideItem> tideItemsUnique;
    private int selectedPosition = -1;
    private int selectedItem;
    public string output = "";

    public static string Output
    {
        get{return output;}
        set{this.output = value;} 
    }

    public override void OnCreate (Bundle savedInstanceState) 
    {
        base.OnCreate (savedInstanceState);
    }

    public override void OnActivityCreated(Bundle savedInstanceState)
    { 
        base.OnActivityCreated(savedInstanceState);

        View detailsFrame = Activity.FindViewById<View>(Resource.Id.details);

        if (savedInstanceState != null)
        {
            selectedItem = savedInstanceState.GetInt("selectedItem", 0);
            selectedPosition = savedInstanceState.GetInt("selectedItem", 0);
        }

        if (detailsFrame != null && detailsFrame.Visibility == ViewStates.Visible)
        {
            ListView.ChoiceMode = ChoiceMode.Single;
        }
        
        TideItems = new List<TideItem>(); 
        const int numFields = 4;   
        TextParser parser = new TextParser (", ", numFields);   
        
        //get the tide item info from the text file
        var tideList = parser.ParseText (Resources.Assets.Open(@"94340322.txt"));

        //Create new tide items for each set of retrieved data and add them to the list
        foreach (string[] tideInfo in tideList)   
        {
            TideItems.Add (new TideItem (tideInfo [0], tideInfo [1], tideInfo [2], tideInfo [3]+" (in feet)"));
        }

        List<string[]> tideListSorted = new List<string[]>(); 
        tideListSorted = tideList; 
        tideListSorted.Sort((x, y) => String.Compare(x[0], y[0], StringComparison.Ordinal)); 

        tideItemsUnique = new List<TideItem>(); 
        
        //Filtering the list of TideItems for unique dates. 
        //The unique list is for showing the user a list of dates, and the full list is parsed when a user clicks on a particular date.
        //At the time this was written I didn't know about LINQ or other alternatives.
        string currentDate = "";
        string storedDate = "";
        foreach (string[] tideInfo in tideListSorted) 
        {             
            //for the first time
            if (storedDate == "") 
            {
                storedDate = tideInfo [0];
                tideItemsUnique.Add (new TideItem (tideInfo [0], tideInfo [1], tideInfo [2], tideInfo [3]+" (in feet)"));
            }

            //every other time
            currentDate = tideInfo [0];
            if(currentDate != storedDate)
            {
                storedDate = currentDate;
                tideItemsUnique.Add (new TideItem (tideInfo [0], tideInfo [1], tideInfo [2], tideInfo [3]+" (in feet)"));
            }
        }
        var adapter = new TideAdapter(Activity, tideItemsUnique); 
        ListAdapter = adapter;
    }

    
    public override void OnListItemClick(ListView l, View v, int position, long id) 
    {
        output = "\
        selectedPosition = position;
        ShowDetails(position);
    }
    

    private void ShowDetails(int index)
    {
        index = index;
        selectedPosition = index;
        View detailsFrame = Activity.FindViewById<View>(Resource.Id.details);

        TideItem selectedTideItem = tideItemsUnique[index];
        
        //get out all the relevant times and tides for a clicked date
        foreach(TideItem TI in TideItems) 
        {
            if (TI.Date == selectedTideItem.Date) 
            {
                output += TI.Time + " " + TI.Tide + " ";
            }
        }
        
        //if a two fragment layout is being used. detailsFrame only exists when the user's screen is large enough
        if (detailsFrame != null && detailsFrame.Visibility == ViewStates.Visible) 
        {
            ListView.SetItemChecked (index, true); 
            var details = FragmentManager.FindFragmentById (Resource.Id.details) as DetailsFragment;  

            //if the details instance is new, or a different item is clicked
            if (details == null || details.SelectedItem != index) 
            {
                details = DetailsFragment.NewInstance(index, output);
                var ft = FragmentManager.BeginTransaction(); 
                ft.Replace (Resource.Id.details, details);
                ft.SetTransition (FragmentTransit.FragmentFade);
                ft.Commit();  
            }
        }
        //if a one fragment layout is being used
        else 
        {
            //launch a new new details activity using an intent, using the index of the selected item
            var intent = new Intent();
            intent.SetClass (Activity, typeof(DetailsActivity));  
            intent.PutExtra("selectedItem", index);
            intent.PutExtra("output", output);
            StartActivity(intent);
        }
    }
}







[Activity(Label = "a")] //needed an attribute, but doesn't matter what
<b>    class DetailsActivity : Activity</b>
{
    protected override void OnCreate(Bundle bundle)
    {
        base.OnCreate (bundle);
        var index = Intent.Extras.GetInt ("selectedItem", 0);
        var output = Intent.Extras.GetString ("output", "error retrieving tide info");
        var details = DetailsFragment.NewInstance (index, output); 
        var fragmentTransaction = FragmentManager.BeginTransaction();
        fragmentTransaction.Add (Android.Resource.Id.Content, details);
        fragmentTransaction.Commit ();
    }
}






<b>    internal class DetailsFragment : Fragment</b>
{

    public override void OnCreate (Bundle savedInstanceState) 
    {
        base.OnCreate (savedInstanceState);
    }

    public static DetailsFragment NewInstance(int selectedItem)
    {
        var detailsFragTemp = new DetailsFragment {Arguments = new Bundle()};                       
        detailsFragTemp.Arguments.PutInt("selectedItem", selectedItem);
        return detailsFragTemp;
    }

    //overloaded newInstance method, for making a detailsfragment with the tideitem output, previously put into a textview
    public static DetailsFragment NewInstance(int selectedItem, string o) 
    {
        var detailsFragTemp = new DetailsFragment {Arguments = new Bundle()}; 
        detailsFragTemp.Arguments.PutInt("selectedItem", selectedItem);
        detailsFragTemp.Arguments.PutString("output", o);
        return detailsFragTemp;
    }

    public int SelectedItem
    {
        get { return Arguments.GetInt("selectedItem", 0); }
    } 

    public override View OnCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState)
    {
        string output = FragmentClass.Output;
        var scroller = new ScrollView(Activity);
        var tvText = new TextView(Activity);
        var padding = Convert.ToInt32(TypedValue.ApplyDimension(ComplexUnitType.Dip, 4, Activity.Resources.DisplayMetrics)); 
        tvText.SetPadding(padding, padding, padding, padding);
        tvText.TextSize = 24;
        tvText.Text = output;
        scroller.AddView(tvText); 
        return scroller;
    }
}






<b>    public class TideItem</b>
{
    public string Date { get; set;}
    public string Day { get; set;}
    public string Time { get; set;}
    public string Tide { get; set;}

    public TideItem(string date, string day, string time, string tide)
    {
        Date = date;
        Day = day;
        Time = time;
        Tide = tide;
    }

    public override string ToString ()
    {
        return string.Format ("[TideClass: Date={0}, Day={1}, Time={2}, Tide={3}]", Date, Day, Time, Tide);
    }
}
</pre>
@endsection

