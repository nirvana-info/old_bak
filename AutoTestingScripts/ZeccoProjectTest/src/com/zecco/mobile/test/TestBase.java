package com.zecco.mobile.test;

//import com.zecco.mobile.activity.common.*;
import java.util.ArrayList;
import java.util.HashMap;

import com.jayway.android.robotium.solo.Solo;
import android.test.ActivityInstrumentationTestCase2;
import android.test.suitebuilder.annotation.Smoke;
import android.view.View;
import android.widget.EditText;
import android.widget.LinearLayout;
import android.widget.TextView;

import com.zecco.mobile.R;
import com.zecco.mobile.usercontrol.ExpandedListView;
import com.zecco.mobile.usercontrol.tab.NavTabMenuItem;
import com.zecco.mobile.usercontrol.tab.enums.NavTabBarMenuEnum;

@SuppressWarnings({ "unchecked", "rawtypes" })
public class TestBase extends ActivityInstrumentationTestCase2 {
	private String userName = "Venturaprice";
	private String passWord = "Passw0rd";
	
	public TestBase(String pkg, Class activityClass) {
		super(pkg, activityClass);
	}

	public Solo solo;

	public void setUp() throws Exception {
		solo = new Solo(getInstrumentation(), getActivity());
	}

	@Override
	public void tearDown() throws Exception {
		try {
			solo.finalize();
			solo.finalize();
			
		} catch (Throwable e) {
			e.printStackTrace();
		}
		getActivity().finish();
		super.tearDown();
	}
	
	public void UserSignIn(String un, String pd) throws InterruptedException
    {
	    solo.clearEditText(0);
    	solo.clearEditText(1);
    	solo.enterText(0, un);
    	solo.enterText(1, pd);
		solo.clickOnButton(0);
		solo.sleep(40000);
    }
	
	public void UserSignIn() throws InterruptedException
    {
	    solo.clearEditText(0);
    	solo.clearEditText(1);
    	solo.enterText(0, userName);
    	solo.enterText(1, passWord);
		solo.clickOnButton(0);
		solo.sleep(40000);
    }
	
	public HashMap<String, String> CheckWidget(String _SymbolType) throws InterruptedException
	{
		String Title = "";
		String Company = "";
		String LastPrice = "";
		String TodaysChange = "";
		String Volume  = "";
		String BidSize  = "";
		String AskSize  = "";
		String WeekRange = "";
		String NAV = "";
		String _1DayChange = "";
		String YTDChange= "";
				
		if(_SymbolType.equals("Index"))
		{
			Title = ((TextView)solo.getView(R.id.text_quote_market_position_quote)).getText().toString();     
			Company =  ((TextView)solo.getView(R.id.text_company_market_position_quote)).getText().toString();
			LastPrice = ((TextView)solo.getView(R.id.text_lastprice_market_position_quote)).getText().toString();
			TodaysChange = ((TextView)solo.getView(R.id.text_todaychange_market_position_quote)).getText().toString(); 
			Volume = ((TextView)solo.getView(R.id.text_volume_market_position_quote)).getText().toString();
			WeekRange = ((TextView)solo.getView(R.id.text_52weekrange_market_position_quote)).getText().toString();
		}
		else if(_SymbolType.equals("IndexOther"))
		{
			Title = ((TextView)solo.getView(R.id.text_quote_market_position_quote)).getText().toString();
			Company =  ((TextView)solo.getView(R.id.text_company_market_position_quote)).getText().toString();
			LastPrice = ((TextView)solo.getView(R.id.text_lastprice_market_position_quote)).getText().toString();
			TodaysChange = ((TextView)solo.getView(R.id.text_todaychange_market_position_quote)).getText().toString(); 
			Volume = ((TextView)solo.getView(R.id.text_volume_market_position_quote)).getText().toString();
			WeekRange = ((TextView)solo.getView(R.id.text_52weekrange_market_position_quote)).getText().toString();
		}
		else if(_SymbolType.equals("Stock"))
		{
			Title = ((TextView)solo.getView(R.id.text_quote_market_position_quote)).getText().toString();
			Company =  ((TextView)solo.getView(R.id.text_company_market_position_quote)).getText().toString();
			LastPrice = ((TextView)solo.getView(R.id.text_lastprice_market_position_quote)).getText().toString();
			TodaysChange = ((TextView)solo.getView(R.id.text_todaychange_market_position_quote)).getText().toString();
			Volume = ((TextView)solo.getView(R.id.text_volume_market_position_quote)).getText().toString();
			BidSize = ((TextView)solo.getView(R.id.text_bid_market_position_quote)).getText().toString();
			AskSize = ((TextView)solo.getView(R.id.text_ask_market_position_quote)).getText().toString();
		}
		else if(_SymbolType.equals("ETFs"))
		{
			Title = ((TextView)solo.getView(R.id.text_quote_market_position_quote)).getText().toString();
			Company =  ((TextView)solo.getView(R.id.text_company_market_position_quote)).getText().toString();
			LastPrice = ((TextView)solo.getView(R.id.text_lastprice_market_position_quote)).getText().toString();
			TodaysChange = ((TextView)solo.getView(R.id.text_todaychange_market_position_quote)).getText().toString();
			Volume = ((TextView)solo.getView(R.id.text_volume_market_position_quote)).getText().toString();
			BidSize = ((TextView)solo.getView(R.id.text_bid_market_position_quote)).getText().toString();
			AskSize = ((TextView)solo.getView(R.id.text_ask_market_position_quote)).getText().toString();
		}
		else if(_SymbolType.equals("MF"))
		{
			Title = ((TextView)solo.getView(R.id.text_quote_market_position_quote)).getText().toString();
			Company =  ((TextView)solo.getView(R.id.text_company_market_position_quote)).getText().toString();
			NAV = ((TextView)solo.getView(R.id.text_van_market_position_quote)).getText().toString();
			_1DayChange = ((TextView)solo.getView(R.id.text_1daychange_market_position_quote)).getText().toString();
			YTDChange = ((TextView)solo.getView(R.id.text_ytdchange_market_position_quote)).getText().toString();
		}
		else if(_SymbolType.equals("Options"))
		{
			Title = ((TextView)solo.getView(R.id.text_quote_market_position_quote)).getText().toString();
			Company =  ((TextView)solo.getView(R.id.text_company_market_position_quote)).getText().toString();
			LastPrice = ((TextView)solo.getView(R.id.text_lastprice_market_position_quote)).getText().toString();
			TodaysChange = ((TextView)solo.getView(R.id.text_todaychange_market_position_quote)).getText().toString();
			Volume = ((TextView)solo.getView(R.id.text_volume_market_position_quote)).getText().toString();
			BidSize = ((TextView)solo.getView(R.id.text_bid_market_position_quote)).getText().toString();
			AskSize = ((TextView)solo.getView(R.id.text_ask_market_position_quote)).getText().toString();
		}
		else if(_SymbolType.equals("ComplextOptions"))
		{
			Title = ((TextView)solo.getView(R.id.text_quote_market_position_quote)).getText().toString();
			Company =  ((TextView)solo.getView(R.id.text_company_market_position_quote)).getText().toString();
			LastPrice = ((TextView)solo.getView(R.id.text_lastprice_market_position_quote)).getText().toString();
			TodaysChange = ((TextView)solo.getView(R.id.text_todaychange_market_position_quote)).getText().toString();
			Volume = ((TextView)solo.getView(R.id.text_volume_market_position_quote)).getText().toString();
			BidSize = ((TextView)solo.getView(R.id.text_bid_market_position_quote)).getText().toString();
			AskSize = ((TextView)solo.getView(R.id.text_ask_market_position_quote)).getText().toString();
		}
		else if(_SymbolType.equals("Other"))
		{
			 Title = ((TextView)solo.getView(R.id.text_quote_market_position_quote)).getText().toString();
			 Company =  ((TextView)solo.getView(R.id.text_company_market_position_quote)).getText().toString();
			 LastPrice = ((TextView)solo.getView(R.id.text_lastprice_market_position_quote)).getText().toString();
			 TodaysChange = ((TextView)solo.getView(R.id.text_todaychange_market_position_quote)).getText().toString();
			 Volume = ((TextView)solo.getView(R.id.text_volume_market_position_quote)).getText().toString();
			 BidSize = ((TextView)solo.getView(R.id.text_bid_market_position_quote)).getText().toString();
			 AskSize = ((TextView)solo.getView(R.id.text_ask_market_position_quote)).getText().toString();
		}
		else
		{
			assertTrue(false);
		}
		
		HashMap<String, String> h = new HashMap<String, String>();
		h.put("Title", Title);
		h.put("Company", Company);
		h.put("LastPrice", LastPrice);
		h.put("TodaysChange", TodaysChange);
		h.put("Volume", Volume);
		h.put("BidSize", BidSize);
		h.put("AskSize", AskSize);
		h.put("WeekRange", WeekRange);
		h.put("NAV", NAV);
		h.put("_1DayChange", _1DayChange);
		h.put("YTDChange", YTDChange);

		return h;
	}
	
	public void CheckTab(String _SymbolType) throws InterruptedException
	{
		
		ArrayList<NavTabBarMenuEnum> tabs = new ArrayList<NavTabBarMenuEnum>();
//		Index
		if(_SymbolType.equals("Index"))
		{
//			tabs.clear();
//			tabs.add(NavTabBarMenuEnum.Chart);
//			tabs.add(NavTabBarMenuEnum.News);
//			tabs.add(NavTabBarMenuEnum.MarketMovers);
//			tabs.add(NavTabBarMenuEnum.Options);
			this._SubCheckTab(3,true, false, true, true, false, false, false);
		}
		//IndexOther
		//1_Chart, 2_News, 3_Movers, 4_Options, 5_Profile, 6_Portfolios, 7_Community
		else if(_SymbolType.equals("IndexOther"))
		{
			this._SubCheckTab(2,true, false, false, true, false, false, false);
		}
		//Stoke
		else if(_SymbolType.equals("Stock"))
		{
			this._SubCheckTab(5,true, true, false, true, true, false, true);
		}
		//ETFs
		else if(_SymbolType.equals("ETFs"))
		{
			this._SubCheckTab(4,true, false, false, true, true, false, true);
		}
		//MF
		else if(_SymbolType.equals("MF"))
		{
			this._SubCheckTab(3,true, false, false, false, true, true, false);
		}
		//Other
		else if(_SymbolType.equals("Other"))
		{
			this._SubCheckTab(2,true, true, false, false, false, false, false);
		}
		else
		{
			assertTrue(false);
		}
	}
	
    public void _SubCheckTab(int count, boolean _Chart, boolean _News, boolean _Movers, boolean _Options, boolean _Profile, boolean _Portfolios, boolean _Community) throws InterruptedException
    {
    	//Showed tab
		LinearLayout tabView = (LinearLayout)solo.getView(R.id.layout_nav_tabs);
		assertEquals("Tab Numbers ", tabView.getChildCount(), count);
		for (int i = 0; i < tabView.getChildCount(); i++) {
			View chd = tabView.getChildAt(i);
			NavTabMenuItem tabItem = (NavTabMenuItem)chd.getTag();
			NavTabBarMenuEnum tabEnum = NavTabBarMenuEnum.convertToEnum(tabItem.GetId());
			
			switch (tabEnum) {
			case Chart:
				assertEquals("Chart tab displays abnormally", _Chart, true); 
				break;
			case Options:
				assertEquals("Options tab displays abnormally", _Options, true); 
				break;
			case Community:
				assertEquals("Community tab displays abnormally", _Community, true); 
				break;
			case MarketMovers:
				assertEquals("Movers tab displays abnormally", _Movers, true); 
				break;
			case News:
				assertEquals("News tab displays abnormally", _News, true); 
				break;
			case Portfolio:
				assertEquals("Portfolios tab displays abnormally", _Portfolios, true); 
				break;
			case Profile:
				assertEquals("Profile tab displays abnormally", _Profile, true); 
				break;
			default:
				break;
			}
		}

    }


}
