package searcher.agents.searcher;

import java.util.ArrayList;
import java.util.List;

import searcher.Article;

public class DummySearcherAgent2 extends DummySearcherAgent {
	protected static ArrayList<Article> pages;
	
	static{
		 pages = new ArrayList<Article>();
		 pages.add(new Article ("page1",3)); 
		 pages.add(new Article ("page2",4));
		 pages.add(new Article ("page3",6));
	}

	public DummySearcherAgent2() {
		// TODO Auto-generated constructor stub
	}

	@Override
	public List<Article> getPages() {
		return pages;
	}

}