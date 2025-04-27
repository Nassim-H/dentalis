const Card = ({ title, children }) => {
    return (
      <div className="bg-white shadow-lg rounded-lg p-4 border border-gray-200">
        <h3 className="text-lg font-semibold text-dark">{title}</h3>
        <div className="mt-2">{children}</div>
      </div>
    );
  };
  
  export default Card;
  