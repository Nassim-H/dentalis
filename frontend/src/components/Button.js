const Button = ({ children, onClick, type = "button", className = "" }) => {
  return (
    <button
      type={type}
      onClick={onClick}
      className={`bg-primary text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-600 transition ${className}`}
    >
      {children}
    </button>
  );
};

export default Button;
