package searcher.agents.searcher;

import searcher.agents.courier.CourierAgent;
import searcher.agents.user.UserAgent;
import searcher.exceptions.InitAgentException;
import jade.core.Agent;
import jade.core.behaviours.CyclicBehaviour;
import jade.lang.acl.ACLMessage;
import jade.lang.acl.MessageTemplate;

public class SearcherCyclicBehaviour extends CyclicBehaviour {

	private SearcherAgent agent;

	public SearcherCyclicBehaviour(SearcherAgent a) {
		agent = a;
		// TODO Auto-generated constructor stub
	}

	@Override
	public void action() {
		ACLMessage msgINIT = agent.receive(MessageTemplate
				.MatchPerformative(UserAgent.INIT));
		try {
			if (msgINIT != null) {
				if (msgINIT.getContent().equals(SearcherAgent.INIT_USER)) {
					agent.setUserAID(msgINIT.getSender());
					System.out.println(agent.getName()+" resive msg: INIT_USER");
				} else if (msgINIT.getSender().equals(agent.getUserAgentAID())) {
					agent.setCourierAID(msgINIT.getContent());
					System.out.println(agent.getName()+" resive msg: " + msgINIT.getContent());
				} else {
					throw new InitAgentException();
				}
			}
		} catch (InitAgentException e) {
			// TODO: handle exception
			e.printStackTrace();
		} 
		ACLMessage msg = agent.receive(MessageTemplate
				.MatchPerformative(ACLMessage.INFORM));
		if(msg != null){
			if(msg.getSender().equals(agent.getCourierAgentAID())){
				agent.sendSearchResult(agent.search(msg));
				System.out.println(agent.getName()+" resive search msg: "+ msg.getContent());
			}
		}else{
			this.block();
		}
		
	}



}